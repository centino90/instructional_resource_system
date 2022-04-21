<?php

namespace App\Http\Controllers;

use App\Events\ResourceCreated;
use App\Http\Requests\StoreNewResourceVersionRequest;
use App\Http\Requests\StoreResourceByUrlRequest;
use App\Http\Requests\StoreResourceRequest;
use App\Http\Requests\StoreSyllabusRequest;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\Media;
use App\Models\Resource;
use App\Models\ResourceType;
use App\Models\Syllabus;
use App\Models\TemporaryUpload;
use App\Models\TypologyStandard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade as PDF;
use Dompdf\Dompdf;
use Illuminate\Contracts\Cache\Store;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

use PhpOffice\PhpWord;
use PhpOffice\PhpWord\IOFactory;

class SyllabusController extends Controller
{
    private $typologyVerbs = [];

    public function __construct()
    {
        $this->typologyVerbs = TypologyStandard::where('enabled', true)->first()->verbs;
    }

    public function create(Course $course)
    {
        $resourceActivities = $course->resources()->with('activityLogs')->where('is_syllabus', true)->get()->map(function ($item, $key) {
            return $item->activityLogs->filter(function ($value, $key) {
                return Str::contains($value->log_name, ['resource-created', 'resource-versioned']);
            });
        })->flatten()->sortByDesc('created_at');

        return view('pages.course-syllabus-create', compact('course', 'resourceActivities'));
    }

    public function upload(Request $request, Course $course)
    {
        $file = $request->file;
        $temporaryFile = TemporaryUpload::where('folder_name', $file)->first();

        $courseSyllabus = $course->latestSyllabus;

        if (!$temporaryFile) {
            $temporaryFile = $courseSyllabus->currentMediaVersion;
            $filePath = $temporaryFile->getPath();
            $resource = $courseSyllabus;
        } else {
            if (!$courseSyllabus) {
                $batchId = Str::uuid();
                $resource = Resource::create([
                    'title' => $request->title,
                    'lesson_id' => $request->lesson_id ?? null,
                    'course_id' => $request->course_id,
                    // 'resource_type_id' => ResourceType::TYPE_SYLLABUS,
                    'user_id' => auth()->id(),
                    'description' => $request->description,
                    'approved_at' => null,
                    'batch_id' => $batchId,
                    'is_syllabus' => true,
                ]);
                event(new ResourceCreated($resource));
            } else {
                $resource = $courseSyllabus;

                // event(new ResourceCreated($resource)); new version added
            }

            $filePath = storage_path('app/public/resource/tmp/' . $temporaryFile->folder_name . '/' . $temporaryFile->file_name);
            $newFilePath = $this->filenameFormatter('users/' . auth()->id() . '/resources/' . $temporaryFile->file_name);
            $newFilename = pathinfo($newFilePath, PATHINFO_FILENAME) . '.' . pathinfo($newFilePath, PATHINFO_EXTENSION);

            Storage::disk('public')->putFileAs('users/' . auth()->id() . '/resources', $filePath, $newFilename);
            $resource->addMedia($filePath)->toMediaCollection();
            Storage::deleteDirectory("app/public/resource/tmp/{$temporaryFile->folder_name}");
            $temporaryFile->delete();

            // override pending media
            $t = $resource->currentMediaVersion->id;
            if ($resource->verificationStatus == 'Pending' && !empty($courseSyllabus)) {
                Media::find($resource->currentMediaVersion->id)->delete();

                $resource->refresh();
            } else {
                $resource->update([
                    'approved_at' => null
                ]);

                $resource->refresh();
            }

            $filePath = $resource->currentMediaVersion->getPath();
        }

        // load converter
        $phpWord = IOFactory::load($filePath);

        // set word filename and srcpath
        $origname = pathinfo($temporaryFile->file_name, PATHINFO_FILENAME);
        $source = storage_path('app/public/') . $origname . '.html';

        // Writing and Saving the doc as html
        $objWriter = IOFactory::createWriter($phpWord, 'HTML');
        $html = $objWriter->getContent($source);

        // dd('nonono', $resource);

        // set verb checking standard
        $verbs = $this->typologyVerbs;

        // remove default style
        /* preg_match('/<body>(.*?)<\/body>/s', $html, $match); */

        $resource->html = $html;


        return view('pages.syllabus-validation')->with([
            'course' => $resource->course,
            'resource' => $resource,
            'verbs' => $verbs
        ]);
    }

    public function uploadByUrl(Request $request, Course $course)
    {
        $filePath = str_replace(url('storage') . '/', "", $request->fileUrl);
        $fileName = pathinfo($this->filenameFormatter($filePath), PATHINFO_FILENAME) . '.' . pathinfo($this->filenameFormatter($filePath), PATHINFO_EXTENSION);
        $fileExt = pathinfo($this->filenameFormatter($filePath), PATHINFO_EXTENSION);

        if (!in_array($fileExt, ['doc', 'docx'])) {
            return redirect()->back()
                ->withErrors([
                    'message' => 'Syllabus file types must be doc or docx.'
                ])->withInput();
        }

        $courseSyllabus = $course->latest_syllabus;

        if (!$courseSyllabus) {
            $batchId = Str::uuid();
            $resource = Resource::create([
                'title' => $request->title,
                'lesson_id' => $request->lesson_id ?? null,
                'course_id' => $request->course_id,
                'user_id' => auth()->id(),
                'description' => $request->description,
                'approved_at' => null,
                'batch_id' => $batchId,
                'is_syllabus' => 1,
            ]);
            event(new ResourceCreated($resource));
        } else {
            $resource = $courseSyllabus;

            // event(new ResourceCreated($resource)); new version added
        }
        $filePath = storage_path('app/public/' . $filePath);
        $resource->addMedia($filePath)->preservingOriginal()->toMediaCollection();

        // override pending media
        if ($resource->verificationStatus == 'Pending' && !empty($courseSyllabus)) {
            Media::find($resource->currentMediaVersion->id)->delete();
        } else {
            $resource->update([
                'approved_at' => null
            ]);

            $resource->refresh();
        }

        $phpWord = IOFactory::load($filePath);

        $origname = pathinfo($fileName, PATHINFO_FILENAME);
        $source = storage_path('app/public/') . $origname . '.html';

        // Saving the doc as html
        $objWriter = IOFactory::createWriter($phpWord, 'HTML');
        $html = $objWriter->getContent($source);

        $verbs = $this->typologyVerbs;

        $resource->html = $html;

        // preg_match('/<body>(.*?)<\/body>/s', $html, $match);

        return view('pages.syllabus-validation')->with([
            'course' => $resource->course,
            'resource' => $resource,
            'verbs' => $verbs
        ]);
    }

    private function filenameFormatter($filePath)
    {
        if (Storage::exists($filePath)) {
            // Split filename into parts
            $pathInfo = pathinfo($filePath);
            $extension = isset($pathInfo['extension']) ? ('.' . $pathInfo['extension']) : '';

            // Look for a number before the extension; add one if there isn't already
            if (preg_match('/(.*?)(\d+)$/', $pathInfo['filename'], $match)) {
                // Have a number; get it
                $base = $match[1];
                $number = intVal($match[2]);
            } else {
                // No number; pretend we found a zero
                $base = $pathInfo['filename'];
                $number = 0;
            }

            // Choose a name with an incremented number until a file with that name
            // doesn't exist
            do {
                $filePath = $pathInfo['dirname'] . DIRECTORY_SEPARATOR . $base . '(' . ++$number . ')' . $extension;
            } while (Storage::exists($filePath));
        }

        return $filePath;
    }

    public function confirmValidation(Request $request, Resource $resource)
    {
        if ($resource->hasMultipleMedia) {
            activity()
                ->causedBy($resource->user)
                ->useLog('resource-versioned')
                ->performedOn($resource)
                ->withProperties($resource->toArray())
                ->log("{$resource->user->nameTag} created a new version of {$resource->title} (id: {$resource->id})");
        }

        $resource->update([
            'approved_at' => now(),
        ]);

        $resource->course->update([
            'current_course_outcomes' => $request->course_outcomes,
            'current_learning_outcomes' => $request->learning_outcomes,
            'current_lessons' => $request->lesson
        ]);

        collect($request->lesson)->each(function ($lesson) use ($request) {
            Lesson::create(
                [
                    'title' => $lesson,
                    'user_id' => auth()->id(),
                    'course_id' => $request->course_id
                ]
            );
        });

        return redirect()->route('syllabi.create', $resource->course)->with([
            'status' => 'success',
            'message' => $resource->currentMediaVersion->file_name . ' (Syllabus) was successfully validated and ' . sizeof($request->lesson) . " lesson(s) were successfully created."
        ]);
    }

    public function storeNewVersion(Request $request, Resource $resource)
    {
        $temporaryFile = TemporaryUpload::firstWhere('folder_name', $request->file);

        if ($temporaryFile) {
            $tempFilePath = storage_path('app/public/resource/tmp/' . $temporaryFile->folder_name . '/' . $temporaryFile->file_name);
            $copiedTempFilePath = storage_path('app/public/resource/tmp/presentation.' . pathinfo($tempFilePath, PATHINFO_EXTENSION));
            if (file_exists($copiedTempFilePath)) {
                Storage::disk('public')->delete('resource/tmp/presentation.' . pathinfo($tempFilePath, PATHINFO_EXTENSION));
            }

            if ($resource->verificationStatus == 'Pending' && $resource->hasMultipleMedia) {
                Media::find($resource->currentMediaVersion->id)->delete();
            } else {
                $resource->update([
                    'approved_at' => null,
                    'archived_at' => null
                ]);
            }

            activity()
                ->causedBy(auth()->user())
                ->performedOn($resource)
                ->useLog('resource-attempt-versioned')
                ->withProperties($resource->getChanges())
                ->log(auth()->user()->nameTag . " submitted a new version (resource: {$resource->title}) ({id: $resource->id})");

            Storage::disk('public')->copy('resource/tmp/' . $temporaryFile->folder_name . '/' . $temporaryFile->file_name, 'resource/tmp/presentation.' . pathinfo($tempFilePath, PATHINFO_EXTENSION));
            $resource->addMedia($tempFilePath)->toMediaCollection();
            $temporaryFile->delete();

            $resource->refresh();
        }
        $filePath = $resource->currentMediaVersion->getPath();

        // load converter
        $phpWord = IOFactory::load($filePath);

        // set word filename and srcpath
        $origname = pathinfo($resource->currentMediaVersion->file_name, PATHINFO_FILENAME);
        $source = storage_path('app/public/') . $origname . '.html';

        // Writing and Saving the doc as html
        $objWriter = IOFactory::createWriter($phpWord, 'HTML');
        $html = $objWriter->getContent($source);

        // delete temp file
        Storage::delete($source);

        // set verb checking standard
        $verbs = $this->typologyVerbs;

        // remove default style
        /* preg_match('/<body>(.*?)<\/body>/s', $html, $match); */

        $resource->html = $html;

        return view('pages.syllabus-validation')->with([
            'course' => $resource->course,
            'resource' => $resource,
            'verbs' => $verbs
        ]);
    }

    public function storeNewVersionByUrl(StoreResourceByUrlRequest $request, Resource $resource)
    {
        $filePath = str_replace(url('storage') . '/', "", $request->fileUrl);
        $fileName = pathinfo($this->filenameFormatter($filePath), PATHINFO_FILENAME) . '.' . pathinfo($this->filenameFormatter($filePath), PATHINFO_EXTENSION);
        $fileExt = pathinfo($this->filenameFormatter($filePath), PATHINFO_EXTENSION);

        if ($resource->verificationStatus == 'Pending' && $resource->hasMultipleMedia) {
            Media::find($resource->currentMediaVersion->id)->delete();
        } else {
            $resource->update([
                'approved_at' => null,
                'archived_at' => null
            ]);
        }

        activity()
            ->causedBy(auth()->user())
            ->performedOn($resource)
            ->useLog('resource-attempt-versioned')
            ->withProperties($resource->getChanges())
            ->log(auth()->user()->nameTag . " submitted a new version (resource: {$resource->title}) ({id: $resource->id})");

        $filePath = storage_path('app/public/' . $filePath);
        $resource->addMedia($filePath)->preservingOriginal()->toMediaCollection();

        $resource->refresh();
        $filePath = $resource->currentMediaVersion->getPath();

        $phpWord = IOFactory::load($filePath);

        $origname = pathinfo($fileName, PATHINFO_FILENAME);
        $source = storage_path('app/public/') . $origname . '.html';

        // Saving the doc as html
        $objWriter = IOFactory::createWriter($phpWord, 'HTML');
        $html = $objWriter->getContent($source);

        $verbs = $this->typologyVerbs;

        $resource->html = $html;

        // preg_match('/<body>(.*?)<\/body>/s', $html, $match);

        return view('pages.syllabus-validation')->with([
            'course' => $resource->course,
            'resource' => $resource,
            'verbs' => $verbs
        ]);
    }
}
