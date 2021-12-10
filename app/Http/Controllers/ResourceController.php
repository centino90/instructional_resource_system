<?php

namespace App\Http\Controllers;

use App\Events\ResourceCreated;
use App\Http\Requests\StoreResourceRequest;
use App\Models\Course;
use App\Models\Resource;
use App\Models\TemporaryUpload;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Spatie\Activitylog\Models\Activity;
use Spatie\MediaLibrary\Support\MediaStream;
use ZipStream\Option\Archive as ArchiveOptions;

use PhpOffice\PhpWord;
use PhpOffice\PhpWord\IOFactory;

// use Spatie\MediaLibrary\MediaCollections\Models\Media;

class ResourceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $resources = Resource::with(['activities', 'media', 'users', 'auth', 'course'])
            ->whereNotNull('approved_at')
            ->whereRelation('course', 'program_id', '=', auth()->user()->program_id)
            ->orderByDesc('created_at')
            ->get();

        $activities = Activity::with('subject', 'causer', 'subject.media')->where('subject_type', 'App\Models\Resource')->orderByDesc('created_at')->limit(5)->get();

        return view('resources', compact(['resources', 'activities']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        if ($request->user()->cannot('create', Resource::class)) {
            abort(403);
        }

        // dd(auth()->user()->belongsToProgram(1));

        $courses = Course::whereIn('program_id', auth()->user()->programs()->pluck('id'))->get();

        return view('create-resource')->with([
            'resourceLists' => $request->resourceLists ?? 1,
            'notifications' => auth()->user()->unreadNotifications,
            'courses' => $courses
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreResourceRequest $request)
    {
        // dd($request);
        abort_if(
            $request->user()->cannot('create', Resource::class),
            403
        );

        $batchId = Str::uuid();
        $index = 0;
        foreach ($request->file as $file) {
            $temporaryFile = TemporaryUpload::firstWhere('folder_name', $file);

            if ($temporaryFile) {
                $resp = $temporaryFile->file_name;
                $docxPath = storage_path('app/public/resource/tmp/' . $temporaryFile->folder_name . '/' . $temporaryFile->file_name);

                // load word file
                $phpWord = IOFactory::load($docxPath);
                $section = $phpWord->addSection();

                $filename = explode('.', $resp);
                $origname = $filename[0];
                $source = storage_path('app/public/') . $origname . '.html';

                // Saving the doc as html
                $objWriter = IOFactory::createWriter($phpWord, 'HTML');
                $html = $objWriter->getContent($source);

                // dd($html);
                $cognitive = ['REMEMBER', 'UNDERSTAND', 'APPLY', 'ANALYZE', 'EVALUATE', 'CREATE'];
                $psychomotor = ['PERCEIVE', 'SET', 'RESPOND AS GUIDED', 'ACT', 'RESPOND OVERTLY', 'ADAPT', 'ORGANIZE'];
                $affective = ['RECEIVE', 'RESPOND', 'VALUE', 'ORGANIZE', 'INTERNALIZE', 'CHARACTERIZE'];

                echo '<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">';
                echo $html;
                echo '<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
          <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
          <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.min.js" integrity="sha384-VHvPCCyXqtD5DqJeNxl2dtTyhF78xXNXdkwX1CZeRusQfRKp+tA7hAShOK/B/fQ2" crossorigin="anonymous"></script>
          ';
                echo '<script>';
                echo 'let arr = ' . json_encode($cognitive);
                echo '; $("body").prepend(`<div class="w-full h-full sticky-top bg-white" id="wrapper"></div>`);';
                echo '$("#wrapper").append(`<div class="container overflow-auto h-100 py-5 my-5" id="report"></div>`);';
                echo '$("#report").append(`<ul class="list-group" id=courseOutcomes><h1>Course outcomes verb checking</h1></ul>`);';
                echo '$("#report").append(`<ul class="list-group mt-5" id=studentOutcomes><h1>Student learning outcomes verb checking</h1></ul>`);';
                echo '$("#report").append(`<div class="mt-5" id="result_msg"><h5>% Result summary</h5></div>`);';
                echo '$("#report").append(`<form action="' . route('admin.resources.store') . '" method="POST" id="form" class="my-5">
          <input name="_token" value="' . csrf_token() . '" type="hidden" class="btn btn-lg btn-success mb-3"></input>
          <a href="' . route('resources.create') . '" class="btn btn-lg btn-secondary mb-3">Go back</a>
          <input type="submit" id="submit" value="Submit to proceed" disabled class="btn btn-lg btn-success mb-3"></input>
          <p>Note: You cannot submit to proceed if the system finds inapproriate verb (colored with red) in the course outcomes and student learning outcomes.</p>
          </form>`);';
                echo '

          $("body").addClass("overflow-hidden");

          let failedCourseOutcomesCounter = 0;
          let successCourseOutcomesCounter = 0;
          // Course outcomes
          $("table:eq(1)").find("td:nth-child(2) p").each(function(index, element) {
              let txtContent = element.textContent.trim();
              let firstWord = txtContent.split(" ")[0].trim();
              let withoutFirstWord = txtContent.replace(firstWord, "").trim();

              if(!txtContent || $(element).closest("td")[0] == $("table:eq(1)").find("td:nth-child(2)")[0]) {
                return;
              }

              let d = "";
              if($.inArray(firstWord.toUpperCase(), arr) == -1) {
                  d += `<li class="list-group-item"> <b class="badge badge-success badge-pill align-middle mr-2">✓</b> ${txtContent}</li>`;
                  successCourseOutcomesCounter++;
              } else {
                  d += `<li class="list-group-item bg-danger text-white"> <b><u>${firstWord}</u></b> ${withoutFirstWord} </li>`;
                  failedCourseOutcomesCounter++;
              }

              $("#courseOutcomes").append(d);
          })

          let failedStudentOutcomesCounter = 0;
          let successStudentOutcomesCounter = 0;

          // Student learning outcomes
          $("table:eq(3)").find("td:nth-child(1) p").each(function(index, element) {
              let txtContent = element.textContent.trim();
              let firstWord = txtContent.split(" ")[0].trim();
              let withoutFirstWord = txtContent.replace(firstWord, "").trim();

              console.log($(element).closest("td")[0], $("table:eq(3)").find("td:nth-child(1)")[0]);
              if(!txtContent || $(element).closest("td")[0] == $("table:eq(3)").find("td:nth-child(1)")[0]) {
                return;
              }

              let d = "";
              if($.inArray(firstWord.toUpperCase(), arr) == -1) {
                  d += `<li class="list-group-item"> <b class="badge badge-success badge-pill align-middle mr-2">✓</b> ${txtContent} </li>`;
                  successStudentOutcomesCounter++;
              } else {
                  d += `<li class="list-group-item bg-danger text-white"> <b><u>${firstWord}</u></b> ${withoutFirstWord} </li>`;
                  failedStudentOutcomesCounter++;
              }
              $("#studentOutcomes").append(d);
          })

          let totalFailedCounter = failedCourseOutcomesCounter + failedStudentOutcomesCounter;
          let totalSuccessCounter = successCourseOutcomesCounter + successStudentOutcomesCounter;

          $("#result_msg").append(`
          <table class="table">
              <tbody>
                  <tr>
                      <td></td>
                      <td class="text-center"><b>Not appropriate</b></td>
                      <td class="text-center"><b>Appropriate</b></td>
                  </tr>

                  <tr>
                      <td>Course outcomes</td>
                      <td class="text-center">${failedCourseOutcomesCounter}</td>
                      <td class="text-center">${successCourseOutcomesCounter}</td>
                  </tr>

                  <tr>
                      <td>Student learning outcomes</td>
                      <td class="text-center">${failedStudentOutcomesCounter}</td>
                      <td class="text-center">${successStudentOutcomesCounter}</td>
                  </tr>


                  <tr>
                      <td></td>
                      <td class="text-center"><b>Total: ${totalFailedCounter}</b></td>
                      <td class="text-center"><b>Total: ${totalSuccessCounter}</b></td>
                  </tr>
              </tbody>
          </table>
          `);

          if(totalFailedCounter <= 0) {
              $("#submit").attr("disabled", false);
          } else {
              $("#submit").attr("hidden", true);
          }
          ';
                echo '</script>';

                $temporaryFile->delete();

                $index++;
            }
        }

        exit();

        // phpword
        //   $resp = 'testSet2.docx';
        //   $docxPath = storage_path('app/public/') . $resp;

        Course::whereIn('program_id', auth()->user()->programs()->pluck('id'))->findOrFail($request->course_id);

        try {
            $batchId = Str::uuid();
            $index = 0;
            foreach ($request->file as $file) {
                $temporaryFile = TemporaryUpload::firstWhere('folder_name', $file);

                if ($temporaryFile) {
                    $r = Resource::create([
                        'course_id' => $request->course_id,
                        'user_id' => auth()->id(),
                        'batch_id' => $batchId,
                        'description' => $request->description[$index],
                        'title' => $request->title[$index]
                    ]);

                    $r->users()->attach($r->user_id, ['batch_id' => $batchId]);

                    $r->addMedia(storage_path('app/public/resource/tmp/' . $temporaryFile->folder_name . '/' . $temporaryFile->file_name))
                        ->toMediaCollection();
                    rmdir(storage_path('app/public/resource/tmp/' . $file));

                    event(new ResourceCreated($r));

                    $temporaryFile->delete();

                    $index++;
                }
                // $r = Resource::create([
                //     'course_id' => $request->course_id,
                //     'user_id' => auth()->id(),
                //     'batch_id' => $batchId,
                //     'description' => $request->description[$index],
                //     'title' => $request->title[$index]
                // ]);

                // $r->users()->attach($r->user_id, ['batch_id' => $batchId]);

                // // dd($r);
                // $r->addMediaFromStream($file)
                //     ->usingFileName($file)
                //     ->toMediaCollection();

                // event(new ResourceCreated($r));

                // $index++;
            }

            if ($request->check_stay) {
                return redirect()
                    ->route('resources.create')
                    ->with('success', 'Resource was created successfully');
            }

            return redirect()
                ->route('resources.index')
                ->with('success', 'Resource was created successfully');
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Resource $resource)
    {
        Gate::authorize('view', $resource);

        return $resource;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Resource $resource)
    {
        try {
            Gate::authorize('delete', $resource);

            $resource->delete();
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException  $e) {

            throw abort(401);
        }

        $fileName = $resource->getMedia()[0]->file_name ?? 'unknown file';
        return redirect()->back()
            ->with([
                'status' => 'success-destroy-resource',
                'message' => $fileName . ' was deleted sucessfully!',
                'resource_id' => $resource->id
            ]);
    }

    /**
     * Download the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function download($mediaItem, Request $request)
    {
        if ($mediaItem == 'all') {
            $zipFileName = Course::findOrFail($request->course_id)->title . '-files-' . time() . '.zip';
            $resources = Resource::withTrashed()->get();

            $resourcesWithinCourse = $resources->map(function ($resource) use ($request) {
                return $resource->course_id == $request->course_id ? $resource->getMedia()[0] : null;
            })->reject(function ($resource) {
                return empty($resource);
            });

            return MediaStream::create($zipFileName)
                ->addMedia($resourcesWithinCourse);
        }

        return response()->download(
            Resource::withTrashed()->find($mediaItem)->getMedia()[0]->getPath(),
            Resource::withTrashed()->find($mediaItem)->getMedia()[0]->file_name
        );
    }

    public function downloadAllByCourse(Request $request)
    {
        $zipFileName = Course::findOrFail($request->course_id)->title . '-files-' . time() . '.zip';
        $resources = Resource::where('course_id', $request->course_id)->get();

        $resourcesWithinCourse = $resources->map(function ($resource) use ($request) {
            return $resource->getMedia()[0];
        })->reject(function ($resource) {
            return empty($resource);
        });

        return MediaStream::create($zipFileName)
            ->addMedia($resourcesWithinCourse);
    }

    public function bulkDownload(Request $request)
    {
        if (!isset($request->resource_no)) {
            return redirect()->route('resources.index');
            // add error alert
        }

        $resources = Resource::withTrashed()->whereIn('id', $request->resource_no)
            ->whereHas('media', function ($query) {
                $query->whereNotNull('file_name');
            })->get();
        $zipFileName = auth()->user()->program->title . '-files-' . time() . '.zip';

        $resourcesWithinCourse = $resources->map(function ($resource) {
            return $resource->getMedia()[0];
        })->reject(function ($resource) {
            return empty($resource);
        });

        return MediaStream::create($zipFileName)
            ->addMedia($resourcesWithinCourse);
    }

    public function getResourcesJson(Request $request)
    {
        $resources = Resource::where('course_id', $request->course_id)->get();
        $resourceMedia = $resources->map(function ($resource) {
            return $resource->getMedia()[0];
        })->reject(function ($resource) {
            return empty($resource);
        });

        return response()->json(['resources' => $resourceMedia]);
    }
}
