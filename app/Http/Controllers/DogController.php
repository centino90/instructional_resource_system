<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDogRequest;
use App\Models\Dog;
use App\Models\Resource;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Barryvdh\DomPDF\Facade as PDF;

class DogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        // $array = [
        //     'dog' => ['bawaw' => ['sssss' => ['zzz' =>
        //     'aaa']]]
        // ];

        // dd(is_array(Arr::dot($array)));
        // dd(Dog::find(11)->types['paragraphs']);
        return view('create-dog')
            ->with([
                'courseDescriptionParagraphs' => $request->courseDescriptionParagraphs ?? 1,
                'courseOutcomesParagraphs' => $request->courseOutcomesParagraphs ?? 1,
                'courseOutcomesLists' => $request->courseOutcomesLists ?? 1,
                'learningOutcomesParagraphs' => $request->learningOutcomesParagraphs ?? 1,
                'learningOutcomesLists' => $request->learningOutcomesLists ?? 1,
                'learningPlanLo' => $request->learningPlanLo ?? 1,
                'learningPlanTopic' => $request->learningPlanTopic ?? 1,
                'learningPlanActivities' => $request->learningPlanActivities ?? 1,
                'learningPlanResources' => $request->learningPlanResources ?? 1,
                'learningPlanAssessmentTools' => $request->learningPlanAssessmentTools ?? 1,
                'studentOutputsParagraphs' => $request->studentOutputsParagraphs ?? 1,
                'studentOutputsLists' => $request->studentOutputsLists ?? 1,
                'lists' => $request->lists ?? 1,
                // 'paragraphs' => $request->paragraphs ?? 1
            ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $c_description_paragraphs = isset($request->course_description['paragraphs']) ? count($request->course_description['paragraphs']) : 1;

        $c_outcomes_paragraphs = isset($request->course_outcomes['paragraphs']) ? count($request->course_outcomes['paragraphs']) : 1;
        $c_outcomes_lists = isset($request->course_outcomes['lists']) ? count($request->course_outcomes['lists']) : 1;

        $l_outcomes_paragraphs = isset($request->learning_outcomes['paragraphs']) ? count($request->learning_outcomes['paragraphs']) : 1;
        $l_outcomes_lists = isset($request->learning_outcomes['lists']) ? count($request->learning_outcomes['lists']) : 1;

        $l_plan_lo = isset($request->learning_plan['lo']) ? count($request->learning_plan['lo']) : 1;
        $l_plan_topic = isset($request->learning_plan['topic']) ? count($request->learning_plan['topic']) : 1;
        $l_plan_activities = isset($request->learning_plan['activities']) ? count($request->learning_plan['activities']) : 1;
        $l_plan_resources = isset($request->learning_plan['resources']) ? count($request->learning_plan['resources']) : 1;
        $l_plan_assessment_tools = isset($request->learning_plan['assessment_tools']) ? count($request->learning_plan['assessment_tools']) : 1;

        $s_outputs_paragraphs = isset($request->student_outputs['paragraphs']) ? count($request->student_outputs['paragraphs']) : 1;
        $s_outputs_lists = isset($request->student_outputs['lists']) ? count($request->student_outputs['lists']) : 1;

        $validator = Validator::make($request->all(), [
            'course_code' => 'required',
            'course_title' => 'required',
            'credit' => 'required',
            'time_allotment' => 'required',
            'professor' => 'required',

            'course_description.paragraphs.*' => 'required',

            'course_outcomes.paragraphs.*' => 'required',
            'course_outcomes.lists.*' => 'required',

            'learning_outcomes.paragraphs.*' => 'required',
            'learning_outcomes.lists.*' => 'required',

            'learning_plan.lo.*' => 'required',
            'learning_plan.weeks.*' => 'required',
            'learning_plan.topic.*' => 'required',
            'learning_plan.activities.*' => 'required',
            'learning_plan.resources.*' => 'required',
            'learning_plan.assessment_tools.*' => 'required',

            'student_outputs.paragraphs.*' => 'required',
            'student_outputs.lists.*' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->route(
                'dogs.create',
                [
                    'courseDescriptionParagraphs' => $c_description_paragraphs,
                    'courseOutcomesParagraphs' => $c_outcomes_paragraphs,
                    'courseOutcomesLists' => $c_outcomes_lists,
                    'learningOutcomesParagraphs' => $l_outcomes_paragraphs,
                    'learningOutcomesLists' => $l_outcomes_lists,
                    'learningPlanLo' => $l_plan_lo,
                    'learningPlanTopic' => $l_plan_topic,
                    'learningPlanActivities' => $l_plan_activities,
                    'learningPlanResources' => $l_plan_resources,
                    'learningPlanAssessmentTools' => $l_plan_assessment_tools,
                    'studentOutputsParagraphs' => $s_outputs_paragraphs,
                    'studentOutputsLists' => $s_outputs_lists,
                ]
            )
                ->withErrors($validator)
                ->withInput();
        }

        $d = Dog::create(
            $request->all()
        );

        $pdf = PDF::loadView('pdf.invoice', ['data' => $d])->stream();
        $newFileName = date('Ymd') . '-' . time() . '.pdf';
        Storage::put('public/' . $newFileName, $pdf);

        Resource::create([
            'file' => $newFileName,
            'course_id' => 1,
            'user_id' => auth()->id(),
            'description' => 'lorem 5',
            'is_syllabus' => 1,
            'approved_at' => null,
            'archived_at' => null
        ]);

        return redirect()->route('dogs.create',)->with([
            'success' => 'dog was created successfully'
        ]);
    }

    public function storeAjax(Request $request)
    {
        $newFileName = date('Ymd') . '-' . time() . '.'  . $request->file('pdf_data')->extension();

        Resource::create([
            'file' => $newFileName,
            'course_id' => 1,
            'user_id' => auth()->id(),
            'description' => 'lorem 5',
            'is_syllabus' => 1,
            'approved_at' => null,
            'archived_at' => null
        ]);

        $request->file('pdf_data')->storeAs('public', $newFileName);

        return response()->json(['success' => 'ajax successful']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Dog $dog)
    {
        return view('show-dog')
            ->with('dog', $dog);
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
    public function destroy($id)
    {
        //
    }
}