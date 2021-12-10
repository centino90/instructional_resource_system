<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCourseRequest;
use App\Models\Course;
use App\Models\Resource;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $programs = collect();
        foreach (auth()->user()->programs as $program) {
            $programs = $programs->merge($program->id);
        }

        $courses = Course::whereIn('program_id', $programs)->orderBy('title')->get();
        return view('courses', compact('courses'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('create-course')
            ->with('programs', auth()->user()->programs);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCourseRequest $request)
    {
        $course =  Course::create($request->validated());

        $message = 'was created successfully!';
        return redirect()->route('courses.index')
            ->with([
                'status' => 'success',
                'message' => '[' . $course->code . '] ' . $course->title . ' ' . $message,
                'course_id' => $course->id
            ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Course $course)
    {
        $r = Resource::withTrashed()->get();
        $resources = $r->map(function ($resource) use ($course) {
            return $resource->course_id == $course->id ? $resource : null;
        })->reject(function ($resource) {
            return empty($resource);
        });
        $activities = $resources->map(function ($item, $key) {
            return $item->activities;
        })->flatten()->sortByDesc('created_at');

        return view('show-course', compact(['course', 'resources', 'activities']));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Course $course)
    {
        return view('edit-course')
            ->with('course', $course)
            ->with('programs', auth()->user()->programs);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreCourseRequest $request, $id)
    {
        $course =  Course::find($id)->update($request->validated());

        $message = 'was updated successfully!';
        return redirect()->route('courses.index')
            ->with([
                'status' => 'success',
                'message' => '[' . $request->code . '] ' . $request->title . ' ' . $message,
                'course_id' => $id
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
        $course = Course::findOrFail($id);
        $course->delete();

        $message = 'was deleted successfully!';
        return redirect()->route('courses.index')
            ->with([
                'status' => 'success',
                'message' => '[' . $course->code . '] ' . $course->title . ' ' . $message,
                'course_id' => $id
            ]);
    }
}
