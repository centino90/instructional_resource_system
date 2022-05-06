<?php

namespace App\Http\Controllers;

use App\Events\ResourceCreated;
use App\HelperClass\OfficeToPdfHelper;
use App\HelperClass\OOXMLTextExtractionHelper;
use App\Http\Requests\StoreResourceByUrlRequest;
use App\Http\Requests\StoreResourceRequest;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\Media;
use App\Models\Resource;
use App\Models\TemporaryUpload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use NcJoes\OfficeConverter\OfficeConverter;

class PresentationResourceController extends Controller
{

    public function upload(Request $request)
    {
        $batchId = Str::uuid();
        $index = 0;
        $resources = collect([]);

        foreach ($request->file as $file) {
            $temporaryFile = TemporaryUpload::firstWhere('folder_name', $file);

            if ($temporaryFile) {
                $resource = Resource::create([
                    'lesson_id' => $request->lesson_id,
                    'course_id' => $request->course_id,
                    'user_id' => auth()->id(),
                    'batch_id' => $batchId,
                    'description' => $request->description[$index],
                    'title' => $request->title[$index],
                    'approved_at' => null,
                    'is_presentation' => true
                ]);
                $tempFilePath = storage_path('app/public/resource/tmp/' . $temporaryFile->folder_name . '/' . $temporaryFile->file_name);
                $copiedTempFilePath = storage_path('app/public/resource/tmp/presentation.' . pathinfo($tempFilePath, PATHINFO_EXTENSION));
                if (file_exists($copiedTempFilePath)) {
                    Storage::disk('public')->delete('resource/tmp/presentation.' . pathinfo($tempFilePath, PATHINFO_EXTENSION));
                }

                Storage::disk('public')->copy('resource/tmp/' . $temporaryFile->folder_name . '/' . $temporaryFile->file_name, 'resource/tmp/presentation.' . pathinfo($tempFilePath, PATHINFO_EXTENSION));
                $resource->addMedia($tempFilePath)->preservingOriginal()->toMediaCollection();

                $randName = pathinfo($tempFilePath, PATHINFO_BASENAME) . time();
                if (!auth()->user()->isStorageFull()) {
                    Storage::disk('public')->putFileAs('users/' . auth()->id() . '/submissions', $tempFilePath, $randName);
                }

                $extraction = OOXMLTextExtractionHelper::convert_to_text($copiedTempFilePath);
                $lastSlide = end($extraction);

                $texts = collect();
                $urls = collect();
                $hasReferenceWord = false;

                foreach ($lastSlide as $key => $value) {
                    $texts->push(trim($value));

                    $authorAndDateRegex = "/(.+?)\s+\(([0-9]{4}|n.d.|N.D.)\S/";
                    preg_match(
                        $authorAndDateRegex,
                        $value,
                        $matches
                    );
                    $searchThrough = Str::contains(strtolower($value), ['http://', 'https://', 'doi://', 'isbn:', 'issn:']);

                    if (!empty($matches[0]) && $searchThrough) {
                        $urls->push($value);
                    }

                    // search for a word that indicates a reference page
                    $searchThrough = Str::contains(strtolower($value), ['reference', 'references', 'list of reference', 'list of references', 'bibliography']);
                    if ($searchThrough) {
                        $hasReferenceWord = true;
                    }
                }

                $tempName = time() . '.pdf';
                if (file_exists(storage_path('app/public/' . $tempName))) {
                    unlink(storage_path('app/public/' . $tempName));
                }

                // $converter = new OfficeConverter($resource->currentMediaVersion->getPath(), storage_path('app/public'));
                $converter = new OfficeToPdfHelper($resource->currentMediaVersion->getPath(), storage_path('app/public'));
                $converter->convertTo($tempName);

                $nf = storage_path('app/public/' . $tempName);

                $resource->texts = $texts;
                $resource->urls = $urls;
                $resource->hasReferenceWord = $hasReferenceWord;
                $resource->pdf = 'data:' . mime_content_type($nf) . ';base64,' . base64_encode(file_get_contents($nf));

                $resources->push($resource);
            }

            $index++;
        }

        return view('pages.presentation-validation')->with([
            'resources' => $resources,
            'lesson' => Lesson::findOrFail($request->lesson_id)
        ]);
    }

    public function uploadByUrl(StoreResourceByUrlRequest $request)
    {
        $filePath = str_replace(url('storage') . '/', "", $request->fileUrl);
        $fileName = pathinfo($this->filenameFormatter($filePath), PATHINFO_FILENAME) . '.' . pathinfo($this->filenameFormatter($filePath), PATHINFO_EXTENSION);
        $fileExt = pathinfo($this->filenameFormatter($filePath), PATHINFO_EXTENSION);

        $validated = collect($request->validated())->mapWithKeys(function ($value, $key) {
            return ["presentation-{$key}" => $value];
        });

        if (empty($fileExt) || !in_array($fileExt, ['ppt, pptx'])) {
            return redirect()->back()
                ->withInput($validated->all())
                ->withErrors([
                    'message' => 'file extension should be ppt, pptx'
                ]);
        }

        $batchId = Str::uuid();
        $resource = Resource::create([
            'title' => $request->title,
            'lesson_id' => $request->lesson_id,
            'course_id' => $request->course_id,
            'user_id' => auth()->id(),
            'description' => $request->description,
            'approved_at' => null,
            'batch_id' => $batchId,
            'is_presentation' => 1,
        ]);

        event(new ResourceCreated($resource));

        $filePath = storage_path('app/public/' . $filePath);
        $resource->addMedia($filePath)->preservingOriginal()->toMediaCollection();
        $filePath = $resource->currentMediaVersion->getPath();

        $extraction = OOXMLTextExtractionHelper::convert_to_text($filePath);
        $lastSlide = end($extraction);

        $texts = collect();
        $urls = collect();
        $hasReferenceWord = false;

        foreach ($lastSlide as $key => $value) {
            $texts->push(trim($value));

            $authorAndDateRegex = "/(.+?)\s+\(([0-9]{4}|n.d.|N.D.)\S/";
            preg_match(
                $authorAndDateRegex,
                $value,
                $matches
            );
            $searchThrough = Str::contains(strtolower($value), ['http://', 'https://', 'doi://', 'isbn:', 'issn:']);

            if (!empty($matches[0]) && $searchThrough) {
                $urls->push($value);
            }

            // search for a word that indicates a reference page
            $searchThrough = Str::contains(strtolower($value), ['reference', 'references', 'list of reference', 'list of references', 'bibliography']);
            if ($searchThrough) {
                $hasReferenceWord = true;
            }
        }

        $tempName = time() . '.pdf';
        if (file_exists(storage_path('app/public/' . $tempName))) {
            unlink(storage_path('app/public/' . $tempName));
        }

        $converter = new OfficeConverter($resource->currentMediaVersion->getPath(), storage_path('app/public'));
        $converter->convertTo($tempName);

        $nf = storage_path('app/public/' . $tempName);

        $resource->texts = $texts;
        $resource->urls = $urls;
        $resource->hasReferenceWord = $hasReferenceWord;
        $resource->pdf = 'data:' . mime_content_type($nf) . ';base64,' . base64_encode(file_get_contents($nf));

        return view('pages.presentation-validation')->with([
            'resources' => collect([$resource]),
            'lesson' => Lesson::findOrFail($request->lesson_id)
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

    public function confirmValidation(Request $request)
    {
        $resources = collect($request->resources);
        $failedResources = collect($request->failed_resources);

        Resource::whereIn('id', $failedResources)->delete();

        Resource::whereIn('id', $resources)->update([
            'approved_at' => now()
        ]);

        Resource::whereIn('id', $resources)->each(function ($item, $key) {
            if ($item->hasMultipleMedia) {
                activity()
                    ->causedBy($item->user)
                    ->useLog('resource-versioned')
                    ->performedOn($item)
                    ->withProperties($item->toArray())
                    ->log("{$item->user->nameTag} created a new version of {$item->title} (id: {$item->id})");
            }
        });

        return redirect()->route('resource.create', [$request->lesson, 'submitType' => 'presentation'])->with([
            'status' => 'success',
            'message' => sizeof($resources) . ' presentations were successfully validated.'
        ]);
    }

    public function storeNewVersion(Request $request, Resource $resource)
    {
        $resources = collect([]);

        $temporaryFile = TemporaryUpload::firstWhere('folder_name', $request->file);

        if ($temporaryFile) {
            // exclude unexecutable files
            if (empty(pathinfo($temporaryFile->file_name, PATHINFO_EXTENSION))) {
                $temporaryFile->delete();

                return redirect()->back()->withErrors(
                    [
                        'status' => 'failed',
                        'message' => "{$temporaryFile->file_name} not executable."
                    ]
                );
            }

            $tempFilePath = storage_path('app/public/resource/tmp/' . $temporaryFile->folder_name . '/' . $temporaryFile->file_name);
            $copiedTempFilePath = storage_path('app/public/resource/tmp/presentation.' . pathinfo($tempFilePath, PATHINFO_EXTENSION));
            if (file_exists($copiedTempFilePath)) {
                Storage::disk('public')->delete('resource/tmp/presentation.' . pathinfo($tempFilePath, PATHINFO_EXTENSION));
            }

            if ($resource->verificationStatus == 'Pending' && $resource->hasMultipleMedia) {
                Media::find($resource->currentMediaVersion->id)->delete();
            } else {
                $resource->update([
                    'approved_at' => null
                ]);
            }

            Storage::disk('public')->copy('resource/tmp/' . $temporaryFile->folder_name . '/' . $temporaryFile->file_name, 'resource/tmp/presentation.' . pathinfo($tempFilePath, PATHINFO_EXTENSION));
            $randName = pathinfo($tempFilePath, PATHINFO_BASENAME) . time();
            if (!auth()->user()->isStorageFull()) {
                Storage::disk('public')->putFileAs('users/' . auth()->id() . '/submissions', $tempFilePath, $randName);
            }
            $resource->addMedia($tempFilePath)->toMediaCollection();

            $resource->refresh();
        }
        $filePath = $resource->currentMediaVersion->getPath();

        $extraction = OOXMLTextExtractionHelper::convert_to_text($resource->currentMediaVersion->getPath());
        $lastSlide = end($extraction);

        $texts = collect();
        $urls = collect();
        $hasReferenceWord = false;

        foreach ($lastSlide as $key => $value) {
            $texts->push(trim($value));

            $authorAndDateRegex = "/(.+?)\s+\(([0-9]{4}|n.d.|N.D.)\S/";
            preg_match(
                $authorAndDateRegex,
                $value,
                $matches
            );
            $searchThrough = Str::contains(strtolower($value), ['http://', 'https://', 'doi://', 'isbn:', 'issn:']);

            if (!empty($matches[0]) && $searchThrough) {
                $urls->push($value);
            }

            // search for a word that indicates a reference page
            $searchThrough = Str::contains(strtolower($value), ['reference', 'references', 'list of reference', 'list of references', 'bibliography']);
            if ($searchThrough) {
                $hasReferenceWord = true;
            }
        }

        $tempName = time() . '.pdf';
        if (file_exists(storage_path('app/public/' . $tempName))) {
            unlink(storage_path('app/public/' . $tempName));
        }

        $converter = new OfficeConverter($resource->currentMediaVersion->getPath(), storage_path('app/public'));
        $converter->convertTo($tempName);

        $nf = storage_path('app/public/' . $tempName);

        $resource->texts = $texts;
        $resource->urls = $urls;
        $resource->hasReferenceWord = $hasReferenceWord;
        $resource->pdf = 'data:' . mime_content_type($nf) . ';base64,' . base64_encode(file_get_contents($nf));

        $resources->push($resource);

        return view('pages.presentation-validation')->with([
            'resources' => $resources,
            'lesson' => Lesson::findOrFail($resource->lesson_id)
        ]);
    }
}
