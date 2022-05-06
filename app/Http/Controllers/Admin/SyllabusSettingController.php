<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TypologyStandard;
use App\Http\Requests\StoreTypologyStandardRequest;
use App\Models\SyllabusSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SyllabusSettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(!$syllabusSetting = SyllabusSetting::first()) {
            SyllabusSetting::factory()->count(1)->create();

            $syllabusSetting = SyllabusSetting::first();
        }

        return view('pages.admin.syllabus-setting.index', compact('syllabusSetting'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateTypologyStandardRequest  $request
     * @param  \App\Models\TypologyStandard  $typologyStandard
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $syllabusSetting = SyllabusSetting::findOrFail($id);

        $syllabusSetting->update([
            'course_outcomes_table_no' => $request->course_outcomes_table_no,
            'course_outcomes_row_no' => $request->course_outcomes_row_no,
            'course_outcomes_col_no' => $request->course_outcomes_col_no,
            'student_outcomes_table_no' => $request->student_outcomes_table_no,
            'student_outcomes_row_no' => $request->student_outcomes_row_no,
            'student_outcomes_col_no' => $request->student_outcomes_col_no,
            'lesson_table_no' => $request->lesson_table_no,
            'lesson_row_no' => $request->lesson_row_no,
            'lesson_col_no' => $request->lesson_col_no
        ]);

        return redirect()->back()->with([
            'status' => 'success',
            'message' => 'Syllabus settings were successfully updated'
        ]);
    }
}
