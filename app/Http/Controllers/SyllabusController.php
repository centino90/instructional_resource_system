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
        Course::whereIn('program_id', auth()->user()->programs()->pluck('id'))->findOrFail($request->course_id);

        $index = 0;
        foreach ($request->file as $file) {
            $temporaryFile = TemporaryUpload::firstWhere('folder_name', $file);

            if ($temporaryFile) {
                // $r = Resource::create([
                //     'course_id' => $request->course_id,
                //     'user_id' => auth()->id(),
                //     'batch_id' => $batchId,
                //     'description' => $request->description[$index],
                //     'title' => $request->title[$index],
                //     'is_syllabus' => 1,
                // ]);

                // $s = Syllabus::create([
                //     'resource_id' => $r->id
                // ]);

                // $r->users()->attach($r->user_id, ['batch_id' => $batchId]);

                // $r->addMedia(storage_path('app/public/resource/tmp/' . $temporaryFile->folder_name . '/' . $temporaryFile->file_name))
                //     ->toMediaCollection();
                // rmdir(storage_path('app/public/resource/tmp/' . $file));

                // event(new ResourceCreated($r));

                // $temporaryFile->delete();

                $phpWord = IOFactory::load(storage_path('app/public/resource/tmp/' . $temporaryFile->folder_name . '/' . $temporaryFile->file_name));
                $section = $phpWord->addSection();

                $filename = explode('.', $temporaryFile->file_name);
                $origname = $filename[0];
                $source = storage_path('app/public/') . $origname . '.html';

                // Saving the doc as html
                $objWriter = IOFactory::createWriter($phpWord, 'HTML');
                $html = $objWriter->getContent($source);

                // dd($html);
                $cognitive = ['REMEMBER', 'UNDERSTAND', 'APPLY', 'ANALYZE', 'EVALUATE', 'CREATE'];
                $psychomotor = ['PERCEIVE', 'SET', 'RESPOND AS GUIDED', 'ACT', 'RESPOND OVERTLY', 'ADAPT', 'ORGANIZE'];
                $affective = ['RECEIVE', 'RESPOND', 'VALUE', 'ORGANIZE', 'INTERNALIZE', 'CHARACTERIZE'];

                $cognitive2 = [
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
                ];

                $psychomotor2 = [
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
                    'ORGANIZE' => [
                        'ARRANGE', 'BUILD', 'COMPOSE', 'CONSTRUCT', 'CREATE', 'DESIGN', 'ORIGINATE', 'MAKE'
                    ],
                ];

                $affective2 = [
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

                $verbs2 = array();
                // array_push($verbs2, $psychomotor2);
                // array_push($verbs2, $cognitive2);
                array_push($verbs2, $affective2);

                $standardVerbs = array_merge($psychomotor, $cognitive, $affective);
                $keyedVerbs = [];
                array_push($keyedVerbs, $cognitive);
                array_push($keyedVerbs, $psychomotor);
                array_push($keyedVerbs, $affective);

                // $html .= '<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">';
                $syllabus = $html;
                $html =  '<div class="d-none">';
                $html .=  $syllabus;
                $html .=  '</div>';
                // $html .= '<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
                // <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
                // <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
                //   ';
                $html .= '<script id="syllabus-iframe-script">';
                $html .= '$("#syllabus-iframe-container").find("meta, style").remove();';
                $html .= 'var arr = ' . json_encode($standardVerbs);
                $html .= ';var standardVerbs = ' . json_encode($keyedVerbs);
                $html .= ';var verbs2 = ' . json_encode($verbs2);
                $html .= ';$("#syllabus-iframe-container").prepend(`<div class="w-100 h-100 bg-white" id="wrapper"></div>`);';
                $html .= '$("#wrapper").append(`<div class="" id="report"></div>`);';
                $html .= '$("#report").append(`<ul class="list-group" id=courseOutcomes><h1>Course outcomes verb checking</h1></ul>`);';
                $html .= '$("#report").append(`<ul class="list-group mt-5" id=studentOutcomes><h1>Student learning outcomes verb checking</h1></ul>`);';
                $html .= '$("#report").append(`<div class="mt-5" id="result_msg"><h5>% Result summary</h5></div>`);';
                $html .= '$("#report").append(`
              <a href="javascript:void(0)" id="syllabus-cancel-submission" class="btn btn-lg btn-secondary mb-3">Cancel submission</a>
              <button id="syllabus-submit-submission" disabled class="btn btn-lg btn-success mb-3">Submit to proceed</button>
              <p>Note: You cannot submit to proceed if the system finds inapproriate verb (colored with red) in the course outcomes and student learning outcomes.</p>
              `);';
                $html .= '

              $("body").addClass("overflow-hidden");

              var failedCourseOutcomesCounter = 0;
              var successCourseOutcomesCounter = 0;
              $("#syllabus-iframe-container table").find("td p").each(function(index, element) {
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
                        $(verbs2).each(function(index, item) {
                            if(!item.hasOwnProperty(firstWord.toUpperCase())) {
                                d += `<li class="list-group-item"> <b class="badge bg-success rounded-pill align-middle me-2">✓</b> ${txtContent}</li>`;
                                successCourseOutcomesCounter++;
                            } else {
                                let suggestions = item[firstWord.toUpperCase()].join(", ");
                                d += `<li class="list-group-item bg-danger text-white"> <a class="fw-bold text-white" tabindex="0" type="button" data-bs-trigger="focus" data-bs-toggle="popover" title="Suggested words" data-bs-content="${suggestions}"><u>${firstWord}</u></a> ${withoutFirstWord} </li>`;
                                failedCourseOutcomesCounter++;
                            }
                        });

                        $("#courseOutcomes").append(d);
                    })
                }
              })


              var failedStudentOutcomesCounter = 0;
              var successStudentOutcomesCounter = 0;
              $("#syllabus-iframe-container table").find("td p").each(function(index, element) {
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
                        $(verbs2).each(function(index, item) {
                            if(!item.hasOwnProperty(firstWord.toUpperCase())) {
                                d += `<li class="list-group-item"> <b class="badge bg-success rounded-pill align-middle me-2">✓</b> ${txtContent}</li>`;
                                successStudentOutcomesCounter++;
                            } else {
                                let suggestions = item[firstWord.toUpperCase()].join(", ");
                                d += `<li class="list-group-item bg-danger text-white"> <a class="fw-bold text-white" tabindex="0" type="button" data-bs-trigger="focus" data-bs-toggle="popover" title="Suggested words" data-bs-content="${suggestions}"><u>${firstWord}</u></a> ${withoutFirstWord} </li>`;
                                failedStudentOutcomesCounter++;
                            }
                        });

                        $("#studentOutcomes").append(d);
                    })
                }
              })

              var totalFailedCounter = failedCourseOutcomesCounter + failedStudentOutcomesCounter;
              var totalSuccessCounter = successCourseOutcomesCounter + successStudentOutcomesCounter;

              if(totalFailedCounter == 0 && totalSuccessCounter == 0) {
                $("#wrapper").html("");
                $("#wrapper").append(`
                    <div class="alert alert-danger" role="alert">
                        <h5 class="fw-bold">The submitted file is not a valid syllabus!</h5>
                        <p>Use this <a href="#">syllabus</a> template so that we can appropriately validate your submission.</p>
                    </div>
                `)
              } else {
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
                    $("#syllabus-submit-submission").attr("disabled", false);
                } else {
                    $("#syllabus-submit-submission").attr("hidden", true);
                }
              }

                $("#syllabus-submit-submission").click(function(event) {
                    $(event.target).html(`<div class="d-flex justify-content-center align-items-center">
                        <div class="spinner-border text-white" role="status"></div>
                    </div>`)

                    $.ajax({
                        method: "POST",
                        url: "' . route('syllabi.store') . '",
                        header: {"X-CSRF-TOKEN": "' . csrf_token() . '"},
                        data: {
                            courseId: "' . $request->course_id . '",
                            folder: "' . $file . '",
                            title: "' . $request->title[0] . '",
                            description: "' . $request->description[0] . '",
                        }
                    })
                    .done(function(data) {
                        $("#syllabus-iframe-container").html("");
                        $("#submit-resource-alert-syllabus").parent().addClass("show");
                        $("#submit-resource-alert-syllabus").text("Syllabus was successfully submitted");
                        $("#submit-syllabus-tab-logs").prepend(`
                        <li class="logsRootList list-group-item d-flex justify-content-between lh-sm">
                            <span> ${data.resource.media[0].file_name} </span>
                            <span> ${new Date(data.resource.created_at).toLocaleDateString("en-US", {month: "short", day: "numeric", year: "numeric", hour: "numeric", minute: "numeric", second: "numeric"})} </span>
                            <div>
                                <div class="btn-group dropend">
                                    <button class="btn" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-horizontal"><circle cx="12" cy="12" r="1"/><circle cx="19" cy="12" r="1"/><circle cx="5" cy="12" r="1"/></svg>
                                    </button>
                                    <ul class="dropdown-menu shadow border-0 p-0">
                                        <li class="dropdown-item p-0">
                                            <ul class="list-group" style="min-width: 300px">
                                                <li class="list-group-item">
                                                    <div>
                                                        <h6 class="my-0 fw-bold">
                                                            ${data.resource.user.username}
                                                        </h6>
                                                        <small class="text-muted">Submitter</small>
                                                    </div>
                                                </li>
                                                <li class="list-group-item">
                                                    <div>
                                                        <h6 class="my-0 fw-bold">
                                                            ${data.resource.status}
                                                        </h6>
                                                        <small class="text-muted">Status</small>
                                                    </div>
                                                </li>
                                                <li class="list-group-item">
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <button data-preview-id="${data.resource.id}" class="submitSyllabusPreviewBtns w-100 btn btn-light border text-primary fw-bold">
                                                                Preview
                                                            </button>
                                                        </div>
                                                        <div class="col-6">
                                                            <button data-unsubmit-id="${data.resource.id}" class="syllabusLogsUnsubmit w-100 btn btn-light border-danger text-danger fw-bold">
                                                                Unsubmit
                                                            </button>
                                                        </div>
                                                    </div>
                                                </li>
                                            </ul>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </li>
                    `)
                    let currentLogsCounter = parseInt($("#submit-syllabus-tab-logs-count").text()) + 1;
                    $("#submit-syllabus-tab-logs-count").text(currentLogsCounter);
                    })
                    .fail(function() {
                        alert("error");
                    })
                    .always(function() {
                        $(event.target).removeClass("loading disabled");
                    });
                });

              $("#syllabus-cancel-submission").click(function() {
                $("#syllabus-iframe-container").html("");
              });
              [].slice.call(document.querySelectorAll(`[data-bs-toggle="popover"]`)).forEach(el => new bootstrap.Popover(el));
              ';
                $html .= '</script>';

                $index++;

                // echo $html;
                return response()->json([
                    'status' => 'ok',
                    'message' => 'syllabus was successfully uploaded.',
                    'embed' => $html
                ]);
            }
        }

        return response()->json([
            'status' => 'fail',
            'message' =>  'upload was unsuccessful.',
        ]);


        // $folder = '';
        // if ($request->hasFile('syllabus')) {
        //     $file = $request->file('syllabus');
        //     $filename = substr(
        //         $file->getClientOriginalName(),
        //         0,
        //         strrpos($file->getClientOriginalName(), ".")
        //     );

        //     /* remove any character that is enclosed within a parenthesis e.g. (1), (hello)
        //     and remove spaces */
        //     $spacesRemoved = preg_replace(array('/\((.*?)\)/', '/\s/'), '', $filename);

        //     $newFilename = $spacesRemoved . '.' . $file->getClientOriginalExtension();
        //     $folder = uniqid() . '-' . time();
        //     $file->storeAs('resource/tmp/' . $folder, $newFilename);

        //     TemporaryUpload::create([
        //         'folder_name' => $folder,
        //         'file_name' => $newFilename
        //     ]);

        //     $resp = $newFilename;
        //     // $docxPath = storage_path('app/public/resource/tmp/' .$folder . '/' . $resp);

        //     // load word file
        //     $phpWord = IOFactory::load($request->file('syllabus'));
        //     $section = $phpWord->addSection();

        //     $filename = explode('.', $resp);
        //     $origname = $filename[0];
        //     $source = storage_path('app/public/') . $origname . '.html';

        //     // Saving the doc as html
        //     $objWriter = IOFactory::createWriter($phpWord, 'HTML');
        //     $html = $objWriter->getContent($source);

        //     // dd($html);
        //     $cognitive = ['REMEMBER', 'UNDERSTAND', 'APPLY', 'ANALYZE', 'EVALUATE', 'CREATE'];
        //     $psychomotor = ['PERCEIVE', 'SET', 'RESPOND AS GUIDED', 'ACT', 'RESPOND OVERTLY', 'ADAPT', 'ORGANIZE'];
        //     $affective = ['RECEIVE', 'RESPOND', 'VALUE', 'ORGANIZE', 'INTERNALIZE', 'CHARACTERIZE'];

        //     $standardVerbs = array_merge($psychomotor, $cognitive, $affective);

        //     echo '<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">';
        //     echo $html;
        //     echo '<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
        //   <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
        //   <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.min.js" integrity="sha384-VHvPCCyXqtD5DqJeNxl2dtTyhF78xXNXdkwX1CZeRusQfRKp+tA7hAShOK/B/fQ2" crossorigin="anonymous"></script>
        //   ';
        //     echo '<script>';
        //     echo 'let arr = ' . json_encode($standardVerbs);
        //     echo '; $("body").prepend(`<div class="w-full h-full sticky-top bg-white" id="wrapper"></div>`);';
        //     echo '$("#wrapper").append(`<div class="container overflow-auto h-100 py-5 my-5" id="report"></div>`);';
        //     echo '$("#report").append(`<ul class="list-group" id=courseOutcomes><h1>Course outcomes verb checking</h1></ul>`);';
        //     echo '$("#report").append(`<ul class="list-group mt-5" id=studentOutcomes><h1>Student learning outcomes verb checking</h1></ul>`);';
        //     echo '$("#report").append(`<div class="mt-5" id="result_msg"><h5>% Result summary</h5></div>`);';
        //     echo '$("#report").append(`<form action="' . route('syllabi.store') . '" method="POST" id="form" class="my-5">
        //   <input name="_token" value="' . csrf_token() . '" type="hidden"></input>
        //   <input name="folder" value="' . $folder . '" type="hidden"</input>
        //   <a href="' . route('syllabi.create') . '" class="btn btn-lg btn-secondary mb-3">Go back</a>
        //   <input type="submit" id="submit" value="Submit to proceed" disabled class="btn btn-lg btn-success mb-3"></input>
        //   <p>Note: You cannot submit to proceed if the system finds inapproriate verb (colored with red) in the course outcomes and student learning outcomes.</p>
        //   </form>`);';
        //     echo '

        //   $("body").addClass("overflow-hidden");

        //   let failedCourseOutcomesCounter = 0;
        //   let successCourseOutcomesCounter = 0;
        //   $("table").find("td p").each(function(index, element) {
        //     if($(element).text().toUpperCase().trim() == "COURSE OUTCOMES") {
        //         let excludedRow = element.closest("td");

        //         $(element).closest("table").find("td:nth-child(2) p").each(function(index, element) {
        //             let txtContent = element.textContent.trim();
        //             let firstWord = txtContent.split(" ")[0].trim();
        //             let withoutFirstWord = txtContent.replace(firstWord, "").trim();

        //            if(!txtContent || excludedRow == $(element).closest("td")[0] ) {
        //               return;
        //             }

        //             let d = "";
        //             if($.inArray(firstWord.toUpperCase(), arr) == -1) {
        //                 d += `<li class="list-group-item"> <b class="badge badge-success badge-pill align-middle mr-2">✓</b> ${txtContent}</li>`;
        //                 successCourseOutcomesCounter++;
        //             } else {
        //                 d += `<li class="list-group-item bg-danger text-white"> <b><u>${firstWord}</u></b> ${withoutFirstWord} </li>`;
        //                 failedCourseOutcomesCounter++;
        //             }

        //             $("#courseOutcomes").append(d);
        //         })
        //     }
        //   })


        //   let failedStudentOutcomesCounter = 0;
        //   let successStudentOutcomesCounter = 0;
        //   $("table").find("td p").each(function(index, element) {
        //     if($(element).text().toUpperCase().trim() == "STUDENT LEARNING OUTCOMES") {
        //         let excludedRow = element.closest("td");

        //         $(element).closest("table").find("td:nth-child(1) p").each(function(index, element) {
        //             let txtContent = element.textContent.trim();
        //             let firstWord = txtContent.split(" ")[0].trim();
        //             let withoutFirstWord = txtContent.replace(firstWord, "").trim();

        //             if(!txtContent || excludedRow == $(element).closest("td")[0] ) {
        //               return;
        //             }

        //             let d = "";
        //             if($.inArray(firstWord.toUpperCase(), arr) == -1) {
        //                 d += `<li class="list-group-item"> <b class="badge badge-success badge-pill align-middle mr-2">✓</b> ${txtContent}</li>`;
        //                 successCourseOutcomesCounter++;
        //             } else {
        //                 d += `<li class="list-group-item bg-danger text-white"> <b><u>${firstWord}</u></b> ${withoutFirstWord} </li>`;
        //                 failedCourseOutcomesCounter++;
        //             }

        //             $("#studentOutcomes").append(d);
        //         })
        //     }
        //   })

        //   let totalFailedCounter = failedCourseOutcomesCounter + failedStudentOutcomesCounter;
        //   let totalSuccessCounter = successCourseOutcomesCounter + successStudentOutcomesCounter;

        //   $("#result_msg").append(`
        //   <table class="table">
        //       <tbody>
        //           <tr>
        //               <td></td>
        //               <td class="text-center"><b>Not appropriate</b></td>
        //               <td class="text-center"><b>Appropriate</b></td>
        //           </tr>

        //           <tr>
        //               <td>Course outcomes</td>
        //               <td class="text-center">${failedCourseOutcomesCounter}</td>
        //               <td class="text-center">${successCourseOutcomesCounter}</td>
        //           </tr>

        //           <tr>
        //               <td>Student learning outcomes</td>
        //               <td class="text-center">${failedStudentOutcomesCounter}</td>
        //               <td class="text-center">${successStudentOutcomesCounter}</td>
        //           </tr>


        //           <tr>
        //               <td></td>
        //               <td class="text-center"><b>Total: ${totalFailedCounter}</b></td>
        //               <td class="text-center"><b>Total: ${totalSuccessCounter}</b></td>
        //           </tr>
        //       </tbody>
        //   </table>
        //   `);

        //   if(totalFailedCounter <= 0) {
        //       $("#submit").attr("disabled", false);
        //   } else {
        //       $("#submit").attr("hidden", true);
        //   }
        //   ';
        //     echo '</script>';
        // }
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
        $newFileName = 'syllabus-' . date('Y') . '-' . $temporaryFile->file_name;
        $r = Resource::create([
            'course_id' => $request->courseId,
            'title' => $request->title,
            'description' => $request->description,
            'user_id' => auth()->id(),
            'batch_id' => Str::uuid(),
            'description' => 'lorem',
            'is_syllabus' => 1,
        ]);

        $r->users()->attach($r->user_id, ['batch_id' => $r->batch_id]);

        // $merged = collect($request->validated())->merge(['resource_id' => $r->id]);
        // $s = Syllabus::create([
        //     'resource_id' => $r->id
        // ]);

        // $pdf = PDF::loadView('pdf.invoice', ['data' => $s])->stream();
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

        return response()->json([
            'status' => 'ok',
            'message' => 'syllabus was successfully uploaded.',
            'resource' => $syllabus
        ]);

        // if ($request->check_stay) {
        //     return redirect()
        //         ->route('syllabi.create')
        //         ->with('success', 'Resource was created successfully');
        // }

        // return redirect()
        //     ->route('syllabi.create')
        //     ->with('success', 'Resource was created successfully');
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
