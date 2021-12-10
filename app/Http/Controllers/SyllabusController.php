<?php

namespace App\Http\Controllers;

use App\Events\ResourceCreated;
use App\Http\Requests\StoreResourceRequest;
use App\Http\Requests\StoreSyllabusRequest;
use App\Models\Course;
use App\Models\Resource;
use App\Models\Syllabus;
use App\Models\TemporaryUpload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade as PDF;
use Dompdf\Dompdf;
use Illuminate\Contracts\Cache\Store;
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

    public function upload(StoreSyllabusRequest $request)
    {
        $folder = '';
        if ($request->hasFile('syllabus')) {
            $file = $request->file('syllabus');
            $filename = substr(
                $file->getClientOriginalName(),
                0,
                strrpos($file->getClientOriginalName(), ".")
            );

            /* remove any character that is enclosed within a parenthesis e.g. (1), (hello)
            and remove spaces */
            $spacesRemoved = preg_replace(array('/\((.*?)\)/', '/\s/'), '', $filename);

            $newFilename = $spacesRemoved . '.' . $file->getClientOriginalExtension();
            $folder = uniqid() . '-' . time();
            $file->storeAs('resource/tmp/' . $folder, $newFilename);

            TemporaryUpload::create([
                'folder_name' => $folder,
                'file_name' => $newFilename
            ]);

            $resp = $newFilename;
            // $docxPath = storage_path('app/public/resource/tmp/' .$folder . '/' . $resp);

            // load word file
            $phpWord = IOFactory::load($request->file('syllabus'));
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

            $standardVerbs = array_merge($psychomotor, $cognitive, $affective);

            echo '<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">';
            echo $html;
            echo '<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
          <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
          <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.min.js" integrity="sha384-VHvPCCyXqtD5DqJeNxl2dtTyhF78xXNXdkwX1CZeRusQfRKp+tA7hAShOK/B/fQ2" crossorigin="anonymous"></script>
          ';
            echo '<script>';
            echo 'let arr = ' . json_encode($standardVerbs);
            echo '; $("body").prepend(`<div class="w-full h-full sticky-top bg-white" id="wrapper"></div>`);';
            echo '$("#wrapper").append(`<div class="container overflow-auto h-100 py-5 my-5" id="report"></div>`);';
            echo '$("#report").append(`<ul class="list-group" id=courseOutcomes><h1>Course outcomes verb checking</h1></ul>`);';
            echo '$("#report").append(`<ul class="list-group mt-5" id=studentOutcomes><h1>Student learning outcomes verb checking</h1></ul>`);';
            echo '$("#report").append(`<div class="mt-5" id="result_msg"><h5>% Result summary</h5></div>`);';
            echo '$("#report").append(`<form action="' . route('syllabi.store') . '" method="POST" id="form" class="my-5">
          <input name="_token" value="' . csrf_token() . '" type="hidden"></input>
          <input name="folder" value="' . $folder . '" type="hidden"</input>
          <a href="' . route('syllabi.create') . '" class="btn btn-lg btn-secondary mb-3">Go back</a>
          <input type="submit" id="submit" value="Submit to proceed" disabled class="btn btn-lg btn-success mb-3"></input>
          <p>Note: You cannot submit to proceed if the system finds inapproriate verb (colored with red) in the course outcomes and student learning outcomes.</p>
          </form>`);';
            echo '

          $("body").addClass("overflow-hidden");

          let failedCourseOutcomesCounter = 0;
          let successCourseOutcomesCounter = 0;
          $("table").find("td p").each(function(index, element) {
            if($(element).text().toUpperCase().trim() == "COURSE OUTCOMES") {
                let excludedRow = element.closest("td");

                $(element).closest("table").find("td:nth-child(2) p").each(function(index, element) {
                    let txtContent = element.textContent.trim();
                    let firstWord = txtContent.split(" ")[0].trim();
                    let withoutFirstWord = txtContent.replace(firstWord, "").trim();

                   if(!txtContent || excludedRow == $(element).closest("td")[0] ) {
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
            }
          })


          let failedStudentOutcomesCounter = 0;
          let successStudentOutcomesCounter = 0;
          $("table").find("td p").each(function(index, element) {
            if($(element).text().toUpperCase().trim() == "STUDENT LEARNING OUTCOMES") {
                let excludedRow = element.closest("td");

                $(element).closest("table").find("td:nth-child(1) p").each(function(index, element) {
                    let txtContent = element.textContent.trim();
                    let firstWord = txtContent.split(" ")[0].trim();
                    let withoutFirstWord = txtContent.replace(firstWord, "").trim();

                    if(!txtContent || excludedRow == $(element).closest("td")[0] ) {
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

                    $("#studentOutcomes").append(d);
                })
            }
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
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request);
        $temporaryFile = TemporaryUpload::firstWhere('folder_name', $request->folder);
        $newFileName = 'syllabus-' . date('Ymd') . '-' . time() . '.pdf';
        $r = Resource::create([
            'course_id' => Course::where('program_id', auth()->user()->programs()->first()->id)->first()->id,
            'user_id' => auth()->id(),
            'batch_id' => Str::uuid(),
            'description' => 'lorem',
            'is_syllabus' => 1,
        ]);

        $r->users()->attach($r->user_id, ['batch_id' => $r->batch_id]);

        // $merged = collect($request->validated())->merge(['resource_id' => $r->id]);
        $s = Syllabus::create([
            'resource_id' => $r->id
        ]);

        // $pdf = PDF::loadView('pdf.invoice', ['data' => $s])->stream();
        $r->addMedia(storage_path('app/public/resource/tmp/' . $temporaryFile->folder_name . '/' . $temporaryFile->file_name))
            ->usingFileName($newFileName)
            ->toMediaCollection();
        rmdir(storage_path('app/public/resource/tmp/' . $temporaryFile->folder_name));

        event(new ResourceCreated($r));

        if ($request->check_stay) {
            return redirect()
                ->route('syllabi.create')
                ->with('success', 'Resource was created successfully');
        }

        return redirect()
            ->route('syllabi.create')
            ->with('success', 'Resource was created successfully');
    }


    // public function store(Request $request)
    // {
    //     if (isset($request->syllabus_preview)) {
    //         $pdf = PDF::loadView('pdf.invoice', ['data' => $request->all()]);

    //         return $pdf->download('invoice.pdf');
    //     }

    //     $c_description_paragraphs = isset($request->course_description['paragraphs']) ? count($request->course_description['paragraphs']) : 1;

    //     $c_outcomes_paragraphs = isset($request->course_outcomes['paragraphs']) ? count($request->course_outcomes['paragraphs']) : 1;
    //     $c_outcomes_lists = isset($request->course_outcomes['lists']) ? count($request->course_outcomes['lists']) : 1;

    //     $l_outcomes_paragraphs = isset($request->learning_outcomes['paragraphs']) ? count($request->learning_outcomes['paragraphs']) : 1;
    //     $l_outcomes_lists = isset($request->learning_outcomes['lists']) ? count($request->learning_outcomes['lists']) : 1;

    //     $l_plan_lo = isset($request->learning_plan['lo']) ? count($request->learning_plan['lo']) : 1;
    //     $l_plan_topic = isset($request->learning_plan['topic']) ? count($request->learning_plan['topic']) : 1;
    //     $l_plan_activities = isset($request->learning_plan['activities']) ? count($request->learning_plan['activities']) : 1;
    //     $l_plan_resources = isset($request->learning_plan['resources']) ? count($request->learning_plan['resources']) : 1;
    //     $l_plan_assessment_tools = isset($request->learning_plan['assessment_tools']) ? count($request->learning_plan['assessment_tools']) : 1;

    //     $s_outputs_paragraphs = isset($request->student_outputs['paragraphs']) ? count($request->student_outputs['paragraphs']) : 1;
    //     $s_outputs_lists = isset($request->student_outputs['lists']) ? count($request->student_outputs['lists']) : 1;

    //     $validator = Validator::make($request->all(), [
    //         'course_code' => 'required',
    //         'course_title' => 'required',
    //         'credit' => 'required',
    //         'time_allotment' => 'required',
    //         'professor' => 'required',

    //         'course_description.paragraphs.*' => 'required',

    //         'course_outcomes.paragraphs.*' => 'required',
    //         'course_outcomes.lists.*' => 'required',

    //         'learning_outcomes.paragraphs.*' => 'required',
    //         'learning_outcomes.lists.*' => 'required',

    //         'learning_plan.lo.*' => 'required',
    //         'learning_plan.weeks.*' => 'required',
    //         'learning_plan.topic.*' => 'required',
    //         'learning_plan.activities.*' => 'required',
    //         'learning_plan.resources.*' => 'required',
    //         'learning_plan.assessment_tools.*' => 'required',

    //         'student_outputs.paragraphs.*' => 'required',
    //         'student_outputs.lists.*' => 'required',
    //     ]);

    //     if ($validator->fails()) {
    //         return redirect()->route(
    //             'syllabi.create',
    //             [
    //                 'courseDescriptionParagraphs' => $c_description_paragraphs,
    //                 'courseOutcomesParagraphs' => $c_outcomes_paragraphs,
    //                 'courseOutcomesLists' => $c_outcomes_lists,
    //                 'learningOutcomesParagraphs' => $l_outcomes_paragraphs,
    //                 'learningOutcomesLists' => $l_outcomes_lists,
    //                 'learningPlanLo' => $l_plan_lo,
    //                 'learningPlanTopic' => $l_plan_topic,
    //                 'learningPlanActivities' => $l_plan_activities,
    //                 'learningPlanResources' => $l_plan_resources,
    //                 'learningPlanAssessmentTools' => $l_plan_assessment_tools,
    //                 'studentOutputsParagraphs' => $s_outputs_paragraphs,
    //                 'studentOutputsLists' => $s_outputs_lists,
    //             ]
    //         )
    //             ->withErrors($validator)
    //             ->withInput();
    //     }

    //     $newFileName = 'syllabus-' . date('Ymd') . '-' . time() . '.pdf';
    //     $r = Resource::create([
    //         'course_id' => Course::where('program_id', auth()->user()->program_id)->first()->id,
    //         'user_id' => auth()->id(),
    //         'batch_id' => Str::uuid(),
    //         'description' => 'lorem',
    //         'is_syllabus' => 1,
    //     ]);

    //     $r->users()->attach($r->user_id, ['batch_id' => $r->batch_id]);

    //     $merged = collect($validator->validated())->merge(['resource_id' => $r->id]);
    //     $s = Syllabus::create(
    //         $merged->all()
    //     );

    //     $pdf = PDF::loadView('pdf.invoice', ['data' => $s])->stream();

    //     $r->addMediaFromStream($pdf)
    //         ->usingFileName($newFileName)
    //         ->toMediaCollection();

    //     event(new ResourceCreated($r));

    //     if ($request->check_stay) {
    //         return redirect()
    //             ->route('syllabi.create')
    //             ->with('success', 'Resource was created successfully');
    //     }

    //     return redirect()
    //         ->route('resources.index')
    //         ->with('success', 'Resource was created successfully');
    // }

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
