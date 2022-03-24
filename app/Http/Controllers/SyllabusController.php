<?php

namespace App\Http\Controllers;

use App\Events\ResourceCreated;
use App\Http\Requests\StoreResourceByUrlRequest;
use App\Http\Requests\StoreResourceRequest;
use App\Http\Requests\StoreSyllabusRequest;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\Resource;
use App\Models\Syllabus;
use App\Models\TemporaryUpload;
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
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        dd('yes');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        return view('create-syllabus')->with([
            // 'courseDescriptionParagraphs' => $request->courseDescriptionParagraphs ?? 1,
            // 'courseOutcomesParagraphs' => $request->courseOutcomesParagraphs ?? 1,
            // 'courseOutcomesLists' => $request->courseOutcomesLists ?? 1,
            // 'learningOutcomesParagraphs' => $request->learningOutcomesParagraphs ?? 1,
            // 'learningOutcomesLists' => $request->learningOutcomesLists ?? 1,
            // 'learningPlanLo' => $request->learningPlanLo ?? 1,
            // 'learningPlanTopic' => $request->learningPlanTopic ?? 1,
            // 'learningPlanActivities' => $request->learningPlanActivities ?? 1,
            // 'learningPlanResources' => $request->learningPlanResources ?? 1,
            // 'learningPlanAssessmentTools' => $request->learningPlanAssessmentTools ?? 1,
            // 'studentOutputsParagraphs' => $request->studentOutputsParagraphs ?? 1,
            // 'studentOutputsLists' => $request->studentOutputsLists ?? 1
        ]);
    }

    public function upload(Request $request)
    {
        // Course::whereIn('program_id', auth()->user()->programs()->pluck('id'))->findOrFail($request->course_id);

        $index = 0;

        foreach ($request->file as $file) {
            if (empty($file)) {
                $index++;
                continue;
            }

            $temporaryFile = TemporaryUpload::where('folder_name', $file)->firstOrFail();
            $filePath = storage_path('app/public/resource/tmp/' . $temporaryFile->folder_name . '/' . $temporaryFile->file_name);

            $phpWord = IOFactory::load($filePath);
            $section = $phpWord->addSection();

            // $filename = explode('.', $temporaryFile->file_name);
            $origname = pathinfo($temporaryFile->file_name, PATHINFO_FILENAME);
            $source = storage_path('app/public/') . $origname . '.html';

            // Saving the doc as html
            $objWriter = IOFactory::createWriter($phpWord, 'HTML');
            $html = $objWriter->getContent($source);

            $verbs = [
                'REMEMBER' => [
                    'DEFINE', 'DESCRIBE', 'LABEL', 'LIST', 'MATCH', 'RECALL', 'RECOGNIZE', 'STATE'
                ],
                'UNDERSTAND' => [
                    'CLASSIFY', 'COMPARE', 'DISCUSS', 'EXEMPLIFY', 'EXPLAIN', 'IDENTIFY', 'ILLUSTRATE', 'INFER', 'INTERPRET', 'PREDICT', 'REPORT', 'REVIEW', 'SUMMARIZE', 'TRANSLATE'
                ],
                'APPLY' => [
                    'CHANGE', 'CHOOSE', 'DEMONSTRATE', 'EXECUTE', 'IMPLEMENT', 'PREPARE', 'SOLVE', 'USE'
                ],
                'ANALYZE' => [
                    'ATTRIBUTE', 'DEBATE', 'DIFFERENTIATE', 'DISTINGUISH', 'EXAMINE', 'ORGANIZE', 'RESEARCH'
                ],
                'EVALUATE' => [
                    'APPRAISE', 'CHECK', 'CRITIQUE', 'JUDGE'
                ],
                'CREATE' => [
                    'COMPOSE', 'CONSTRUCT', 'DESIGN', 'DEVELOP', 'FORMULATE', 'GENERATE', 'INVENT', 'MAKE', 'ORGANIZE', 'PLAN', 'PRODUCE', 'PROPOSE'
                ],
                'PERCEIVE' => [
                    'DETECT', 'DIFFERENTIATE', 'DISTINGUISH', 'IDENTIFY', 'OBSERVE', 'RECOGNIZE', 'RELATE'
                ],
                'SET' => [
                    'ASSUME A STANCE', 'DISPLAY', 'PERFORM MOTOR SKILLS', 'POSITION THE BODY', 'PROCEED', 'SHOW'
                ],
                'RESPOND AS GUIDED' => [
                    'COPY', 'DUPLICATE', 'MITATE', 'OPERATE UNDER SUPERVISION', 'PRACTICE', 'REPEAT', 'REPRODUCE'
                ],
                'ACT' => [
                    'ASSEMBLE', 'CALIBRATE', 'COMPLETE WITH CONFIDENCE', 'CONDUCT', 'CONSTRUCT', 'DEMONSTRATE', 'DISMANTLE', 'FIX', 'EXECUTE', 'IMPROVE EFFICIENCY', 'MAKE', 'MANIPULATE', 'MEASURE', 'MEND', 'ORGANIZE', 'PRODUCE'
                ],
                'RESPOND OVERTLY' => [
                    'ACT HABITUALLY', 'CONTROL', 'DIRECT', 'GUIDE', 'MANAGE', 'PERFORM'
                ],
                'ADAPT' => [
                    'ALTER', 'CHANGE', 'REARRANGE', 'REORGANIZE', 'REVISES'
                ],
                'RECEIVE' => [
                    'ACKNOWLEDGE', 'CHOOSE', 'DEMONSTRATE AWARENESS', 'DEMONSTRATE TOLERANCE', 'LOCATE', 'SELECT'
                ],
                'RESPOND' => [
                    'ANSWER', 'COMMUNICATE', 'COMPLY', 'CONTRIBUTE', 'COOPERATE', 'DISCUSS', 'PARTICIPATE WILLINGLY', 'VOLUNTEER'
                ],
                'VALUE' => [
                    'ADOPT', 'ASSUME RESPONSIBILITY', 'BEHAVE ACCORDING TO', 'CHOOSE', 'COMMIT', 'EXPRESS', 'INITIATE', 'JUSTIFY', 'PROPOSE', 'SHOW CONCERN', 'USE RESOURCES TO'
                ],
                'ORGANIZE' => [
                    'BUILD', 'COMPOSE', 'CONSTRUCT', 'CREATE', 'DESIGN', 'ORIGINATE', 'MAKE', 'ADAPT', 'ADJUST', 'ARRANGE', 'BALANCE', 'CLASSIFY', 'CONCEPTUALIZE', 'FORMULATE', 'PREPARE', 'RANK', 'THEORIZE'
                ],
                'CHARACTERIZE' => [
                    'ACT UPON', 'ADVOCATE', 'DEFEND', 'EXEMPLIFY', 'INFLUENCE', 'PERFORM', 'PRACTICE', 'SERVE', 'SUPPORT'
                ],
            ];

            preg_match('/<body>(.*?)<\/body>/s', $html, $match);

            return view('pages.syllabus-validation')->with([
                'lesson' => Lesson::findOrFail($request->lesson_id),
                'formData' => [
                    'type' => 'file',
                    'file' => $request->file[$index],
                    'title' => $request->title[$index],
                    'description' => $request->description[$index],
                ],
                'syllabusHtml' => trim($match[1]),
                'verbs' => $verbs
            ]);
        }

        return response()->json([
            'status' => 'fail',
            'message' =>  'upload was unsuccessful.',
        ]);
    }

    public function lessonCreation(Request $request)
    {
        collect($request->lesson)->each(function ($lesson) use ($request) {
            Lesson::create(
                [
                    'title' => $lesson,
                    'user_id' => auth()->id(),
                    'course_id' => $request->course_id
                ]
            );
        });

        return response()->json([
            'statusCode' => 200,
            'message' => sizeof($request->lesson) . " lesson(s) were successfully created."
        ]);
    }

    public function uploadByUrl(StoreResourceByUrlRequest $request)
    {
        // dd('nani');
        // Course::whereIn('program_id', auth()->user()->programs()->pluck('id'))->findOrFail($request->course_id);

        $filePath = str_replace(url('storage') . '/', "", $request->fileUrl);
        $fileName = pathinfo($this->filenameFormatter($filePath), PATHINFO_FILENAME) . '.' . pathinfo($this->filenameFormatter($filePath), PATHINFO_EXTENSION);
        $fileExt = pathinfo($this->filenameFormatter($filePath), PATHINFO_EXTENSION);

        if (!in_array($fileExt, ['doc', 'docx'])) {
            return redirect()->back()
                ->withErrors([
                    'message' => 'Syllabus file types must be doc or docx.'
                ])->withInput();
        }

        $request->file = [
            'filePath' => storage_path('app/public/' . $filePath),
            'file_name' => $fileName
        ];


        $temporaryFile = $request->file;
        $filePath = $temporaryFile['filePath'];

        $phpWord = IOFactory::load($filePath);
        $section = $phpWord->addSection();

        $origname = pathinfo($temporaryFile['file_name'], PATHINFO_FILENAME);
        $source = storage_path('app/public/') . $origname . '.html';

        // Saving the doc as html
        $objWriter = IOFactory::createWriter($phpWord, 'HTML');
        $html = $objWriter->getContent($source);

        $verbs = [
            'REMEMBER' => [
                'DEFINE', 'DESCRIBE', 'LABEL', 'LIST', 'MATCH', 'RECALL', 'RECOGNIZE', 'STATE'
            ],
            'UNDERSTAND' => [
                'CLASSIFY', 'COMPARE', 'DISCUSS', 'EXEMPLIFY', 'EXPLAIN', 'IDENTIFY', 'ILLUSTRATE', 'INFER', 'INTERPRET', 'PREDICT', 'REPORT', 'REVIEW', 'SUMMARIZE', 'TRANSLATE'
            ],
            'APPLY' => [
                'CHANGE', 'CHOOSE', 'DEMONSTRATE', 'EXECUTE', 'IMPLEMENT', 'PREPARE', 'SOLVE', 'USE'
            ],
            'ANALYZE' => [
                'ATTRIBUTE', 'DEBATE', 'DIFFERENTIATE', 'DISTINGUISH', 'EXAMINE', 'ORGANIZE', 'RESEARCH'
            ],
            'EVALUATE' => [
                'APPRAISE', 'CHECK', 'CRITIQUE', 'JUDGE'
            ],
            'CREATE' => [
                'COMPOSE', 'CONSTRUCT', 'DESIGN', 'DEVELOP', 'FORMULATE', 'GENERATE', 'INVENT', 'MAKE', 'ORGANIZE', 'PLAN', 'PRODUCE', 'PROPOSE'
            ],
            'PERCEIVE' => [
                'DETECT', 'DIFFERENTIATE', 'DISTINGUISH', 'IDENTIFY', 'OBSERVE', 'RECOGNIZE', 'RELATE'
            ],
            'SET' => [
                'ASSUME A STANCE', 'DISPLAY', 'PERFORM MOTOR SKILLS', 'POSITION THE BODY', 'PROCEED', 'SHOW'
            ],
            'RESPOND AS GUIDED' => [
                'COPY', 'DUPLICATE', 'MITATE', 'OPERATE UNDER SUPERVISION', 'PRACTICE', 'REPEAT', 'REPRODUCE'
            ],
            'ACT' => [
                'ASSEMBLE', 'CALIBRATE', 'COMPLETE WITH CONFIDENCE', 'CONDUCT', 'CONSTRUCT', 'DEMONSTRATE', 'DISMANTLE', 'FIX', 'EXECUTE', 'IMPROVE EFFICIENCY', 'MAKE', 'MANIPULATE', 'MEASURE', 'MEND', 'ORGANIZE', 'PRODUCE'
            ],
            'RESPOND OVERTLY' => [
                'ACT HABITUALLY', 'CONTROL', 'DIRECT', 'GUIDE', 'MANAGE', 'PERFORM'
            ],
            'ADAPT' => [
                'ALTER', 'CHANGE', 'REARRANGE', 'REORGANIZE', 'REVISES'
            ],
            'RECEIVE' => [
                'ACKNOWLEDGE', 'CHOOSE', 'DEMONSTRATE AWARENESS', 'DEMONSTRATE TOLERANCE', 'LOCATE', 'SELECT'
            ],
            'RESPOND' => [
                'ANSWER', 'COMMUNICATE', 'COMPLY', 'CONTRIBUTE', 'COOPERATE', 'DISCUSS', 'PARTICIPATE WILLINGLY', 'VOLUNTEER'
            ],
            'VALUE' => [
                'ADOPT', 'ASSUME RESPONSIBILITY', 'BEHAVE ACCORDING TO', 'CHOOSE', 'COMMIT', 'EXPRESS', 'INITIATE', 'JUSTIFY', 'PROPOSE', 'SHOW CONCERN', 'USE RESOURCES TO'
            ],
            'ORGANIZE' => [
                'BUILD', 'COMPOSE', 'CONSTRUCT', 'CREATE', 'DESIGN', 'ORIGINATE', 'MAKE', 'ADAPT', 'ADJUST', 'ARRANGE', 'BALANCE', 'CLASSIFY', 'CONCEPTUALIZE', 'FORMULATE', 'PREPARE', 'RANK', 'THEORIZE'
            ],
            'CHARACTERIZE' => [
                'ACT UPON', 'ADVOCATE', 'DEFEND', 'EXEMPLIFY', 'INFLUENCE', 'PERFORM', 'PRACTICE', 'SERVE', 'SUPPORT'
            ],
        ];

        preg_match('/<body>(.*?)<\/body>/s', $html, $match);

        return view('pages.syllabus-validation')->with([
            'lesson' => Lesson::findOrFail($request->lesson_id),
            'formData' => [
                'type' => 'url',
                'file' => $request->file['filePath'],
                'title' => $request->title,
                'description' => $request->description,
            ],
            'syllabusHtml' => trim($match[1]),
            'verbs' => $verbs
        ]);

        return response()->json([
            'status' => 'fail',
            'message' =>  'upload was unsuccessful.',
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $temporaryFile = TemporaryUpload::firstWhere('folder_name', $request->filePath);

        $newFileName = 'syllabus-' . date('Y') . '-' . $temporaryFile->file_name;
        $r = Resource::create([
            'lesson_id' => $request->lesson_id,
            'course_id' => $request->course_id,
            'title' => $request->title,
            'user_id' => auth()->id(),
            'description' => $request->description,
            'batch_id' => Str::uuid(),
            'is_syllabus' => 1,
            'approved_at' => now()
        ]);

        $r->users()->attach($r->user_id, ['batch_id' => $r->batch_id]);

        $r->addMedia(storage_path('app/public/resource/tmp/' . $temporaryFile->folder_name . '/' . $temporaryFile->file_name))
            ->usingFileName($newFileName)
            ->toMediaCollection();

        rmdir(storage_path('app/public/resource/tmp/' . $temporaryFile->folder_name));

        event(new ResourceCreated($r));

        $syllabus = Resource::with('media', 'user')->findOrFail($r->id);

        $status = !empty($syllabus->approved_at) ? 'approved' : (!empty($syllabus->rejected_at) ? 'rejected' : 'for approval');
        $syllabus->status = $status;
        $isOwner = $syllabus->user_id == auth()->id() ? true : false;
        $syllabus->isOwner = $isOwner;

        collect($request->lesson)->each(function ($lesson) use ($request) {
            Lesson::create(
                [
                    'title' => $lesson,
                    'user_id' => auth()->id(),
                    'course_id' => $request->course_id
                ]
            );
        });

        // $request->flash('status', 'Success');
        // $request->flash('message', 'Syllabus was successfully validated and ' . sizeof($request->lesson) . ' lesson(s) were successfully created');

        return redirect()->route('resource.create', ['submitType' => 'syllabus'])->with([
            'status' => 'success',
            'message' => 'Syllabus was successfully validated and ' . sizeof($request->lesson) . " lesson(s) were successfully created."
        ]);
    }

    public function storeByUrl(StoreResourceByUrlRequest $request)
    {
        $filePath = str_replace(url('storage') . '/', "", $request->filePath);
        $filename = pathinfo($this->filenameFormatter($filePath), PATHINFO_FILENAME) . '.' . pathinfo($this->filenameFormatter($filePath), PATHINFO_EXTENSION);

        $newFileName = 'syllabus-' . date('Y') . '-' . $filename;
        $r = Resource::create([
            'lesson_id' => $request->lesson_id,
            'course_id' => $request->course_id,
            'title' => $request->title,
            'user_id' => auth()->id(),
            'description' => $request->description,
            'batch_id' => Str::uuid(),
            'is_syllabus' => 1,
            'approved_at' => now()
        ]);

        $r->users()->attach($r->user_id, ['batch_id' => $r->batch_id]);

        $r->addMediaFromDisk($filePath, 'public')
            ->usingFileName($newFileName)
            ->preservingOriginal()
            ->toMediaCollection();

        event(new ResourceCreated($r));

        $syllabus = Resource::with('media', 'user')->findOrFail($r->id);

        $status = !empty($syllabus->approved_at) ? 'approved' : (!empty($syllabus->rejected_at) ? 'rejected' : 'for approval');
        $syllabus->status = $status;
        $isOwner = $syllabus->user_id == auth()->id() ? true : false;
        $syllabus->isOwner = $isOwner;

        return response()->json([
            'statusCode' => 200,
            'message' => 'Syllabus was successfully validated and ' . sizeof($request->lesson) . " lesson(s) were successfully created."
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Syllabus  $syllabus
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('show-syllabus');
    }

    public function preview($id)
    {
        $resource = Resource::findOrFail($id);
        Gate::authorize('view', $resource);

        $phpWord = IOFactory::load($resource->getFirstMediaPath());
        $section = $phpWord->addSection();

        $source = storage_path('app/public/') . $resource->getFirstMedia()->name . '.html';

        // Saving the doc as html
        $objWriter = IOFactory::createWriter($phpWord, 'HTML');
        $html = $objWriter->getContent($source);

        $resource->html = $html;

        return $resource;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Syllabus  $syllabus
     * @return \Illuminate\Http\Response
     */
    public function edit(Syllabus $syllabus)
    {
        return view('edit-syllabus')->with('syllabus', $syllabus);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Syllabus  $syllabus
     * @return \Illuminate\Http\Response
     */
    public function update(StoreSyllabusRequest $request, Syllabus $syllabus)
    {
        if (isset($request->syllabus_preview)) {
            $pdf = PDF::loadView('pdf.invoice', ['data' => $request->all()]);

            return $pdf->download('invoice.pdf');
        }

        $syllabus->update(
            $request->validated()
        );

        if ($request->check_stay) {
            return redirect()
                ->route('syllabi.edit', $syllabus->resource_id)
                ->with('success', 'Syllabus was updated successfully');
        }

        return redirect()
            ->route('resources.index')
            ->with('success', 'Syllabus was updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Syllabus  $syllabus
     * @return \Illuminate\Http\Response
     */
    public function destroy(Syllabus $syllabus)
    {
        //
    }
}
