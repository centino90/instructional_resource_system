<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSyllabusRequest;
use App\Models\Resource;
use App\Models\Syllabus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade as PDF;
use Dompdf\Dompdf;
use Illuminate\Support\Facades\Validator;

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
            'studentOutputsLists' => $request->studentOutputsLists ?? 1
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
        if (isset($request->syllabus_preview)) {
            $pdf = PDF::loadView('pdf.invoice', ['data' => $request->all()]);

            return $pdf->download('invoice.pdf');
        }

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
                'syllabi.create',
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

        $newFileName = date('Ymd') . '-' . time() . '.pdf';

        $r = Resource::create([
            'course_id' => 1,
            'user_id' => auth()->id(),
            'description' => 'lorem',
            'is_syllabus' => 1,
        ]);

        $merged = collect($validator->validated())->merge(['resource_id' => $r->id]);
        $s = Syllabus::create(
            $merged->all()
        );

        $pdf = PDF::loadView('pdf.invoice', ['data' => $s])->stream();

        $r->addMediaFromStream($pdf)
            ->usingFileName($newFileName)
            ->toMediaCollection();

        if ($request->check_stay) {
            return redirect()
                ->route('syllabi.create')
                ->with('success', 'Resource was created successfully');
        }

        return redirect()
            ->route('resources.index')
            ->with('success', 'Resource was created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Syllabus  $syllabus
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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