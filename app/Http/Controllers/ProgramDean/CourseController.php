<?php

namespace App\Http\Controllers\ProgramDean;

use App\DataTables\Management\Dean\CoursesDataTable;
use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\User;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(CoursesDataTable $dataTable, Request $request)
    {
        return $dataTable->with('storeType', $request->storeType)->render('pages.dean.courses.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = User::withinAuthPrograms()->instructors()->get();

        return view('pages.dean.courses.create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string',
            'code' => 'required|string',
            'year_level' => 'required|string',
            'semester' => 'required|string',
            'term' => 'required|string',
            'read' => 'nullable|array',
            'write' => 'nullable|array'
        ]);

        $course = Course::create([
            'program_id' => auth()->user()->programs->first()->id
        ] + $validated);

        $assignedCoursesByRead = collect($validated['read'])->filter(fn ($read) => boolval($read));
        $assignedCoursesByWrite = collect($validated['write'])->filter(fn ($write) => boolval($write));
        $mergedAssignedCourses = $assignedCoursesByRead->union($assignedCoursesByWrite);

        $course->users()->syncWithoutDetaching($mergedAssignedCourses->keys());

        if (!empty($validated['read'])) {
            $unAssignedCourses = collect($validated['read'])->filter(fn ($read) => !boolval($read));

            $course->users()->updateExistingPivot($assignedCoursesByRead->keys(), ['view' => true]);
            $course->users()->updateExistingPivot($unAssignedCourses->keys(), ['view' => false]);
        }

        if (!empty($validated['write'])) {
            $unAssignedCourses = collect($validated['write'])->filter(fn ($write) => !boolval($write));

            $course->users()->updateExistingPivot($assignedCoursesByWrite->keys(), ['participate' => true]);
            $course->users()->updateExistingPivot($unAssignedCourses->keys(), ['participate' => false]);
        }

        return redirect()->back()->with([
            'status' => 'success',
            'message' => 'Course was successfully created',
            'updatedSubject' => $course->id
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Course $course)
    {
        $users = User::withinAuthPrograms()->instructors()->get();

        return view('pages.dean.courses.edit', compact('course', 'users'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Course $course)
    {
        $validated = $request->validate([
            'title' => 'required|string',
            'code' => 'required|string',
            'year_level' => 'required|string',
            'semester' => 'required|string',
            'term' => 'required|string',
            'write' => 'nullable|array',
            'read' => 'nullable|array'
        ]);
        $course->update($validated);

        $assignedCoursesByRead = collect($validated['read'])->filter(fn ($read) => boolval($read));
        $assignedCoursesByWrite = collect($validated['write'])->filter(fn ($write) => boolval($write));
        $mergedAssignedCourses = $assignedCoursesByRead->union($assignedCoursesByWrite);

        $course->users()->syncWithoutDetaching($mergedAssignedCourses->keys());

        if (!empty($validated['read'])) {
            $unAssignedCourses = collect($validated['read'])->filter(fn ($read) => !boolval($read));

            $course->users()->updateExistingPivot($assignedCoursesByRead->keys(), ['view' => true]);
            $course->users()->updateExistingPivot($unAssignedCourses->keys(), ['view' => false]);
        }

        if (!empty($validated['write'])) {
            $unAssignedCourses = collect($validated['write'])->filter(fn ($write) => !boolval($write));

            $course->users()->updateExistingPivot($assignedCoursesByWrite->keys(), ['participate' => true]);
            $course->users()->updateExistingPivot($unAssignedCourses->keys(), ['participate' => false]);
        }

        return redirect()->back()->with([
            'status' => 'success',
            'message' => 'Course was successfully updated',
            'updatedSubject' => $course->id
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function archive(Course $course)
    {
        if (!empty($course->archived_at)) {
            $message = $course->title . ' was successfully removed from archive!';
            $course->update([
                'archived_at' => null
            ]);
        } else {
            $message = $course->title . ' was successfully archived!';
            $course->update([
                'archived_at' => now()
            ]);
        }

        return redirect()->back()
            ->with([
                'updatedSubject' => $course->id,
                'status' => 'success',
                'message' => $message,
                'course_id' => $course->id
            ]);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $course = Course::withTrashed()->findOrFail($id);

        if ($course->lessons->isNotEmpty() || $course->lessons->isNotEmpty()) {
            return redirect()->back()
                ->with([
                    'status' => 'fail',
                    'message' => 'Course cannot be trashed since it contain lessons or resources',
                    'updatedSubject' => $course->id,
                    'course_id' => $course->id
                ]);
        }

        if ($course->trashed()) {
            $course->restore();
            $message = 'Course was successfully restored';
        } else {
            $course->delete();
            $message = 'Course was successfully trashed';
        }

        return redirect()->back()
            ->with([
                'status' => 'success',
                'message' => $message,
                'updatedSubject' => $course->id,
                'course_id' => $course->id
            ]);
    }
}
