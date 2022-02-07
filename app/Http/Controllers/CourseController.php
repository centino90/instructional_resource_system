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
        /* ON SUBMIT GENERAL */
        $resource = Resource::with('media', 'user')->where('is_syllabus', false)->where('is_presentation', false)
            ->where('course_id', $course->id)
            ->whereNotNull('approved_at')
            ->whereNull('archived_at')
            ->first();
        $resourcesLogs = Resource::with('media', 'user')->where('is_syllabus', false)->where('is_presentation', false)
            ->where('course_id', $course->id)
            ->orderByDesc('created_at')
            ->limit(5)
            ->get();
        $resourcesLogCount = Resource::where('is_syllabus', false)->where('is_presentation', false)
            ->where('course_id', $course->id)
            ->count();

        /* ON SUBMIT SYLLABUS */
        $syllabus = Resource::with('media', 'user')->where('is_syllabus', true)
            ->where('course_id', $course->id)
            ->whereNotNull('approved_at')
            ->whereNull('archived_at')
            ->first();
        $syllabiLogs = Resource::with('media', 'user')->where('is_syllabus', true)
            ->where('course_id', $course->id)
            ->orderByDesc('created_at')
            ->limit(5)
            ->get();
        $syllabiLogCount = Resource::where('is_syllabus', true)
            ->where('course_id', $course->id)
            ->count();

        /* ON SUBMIT PRESENTATION */
        $presentation = Resource::with('media', 'user')->where('is_presentation', true)
            ->where('course_id', $course->id)
            ->whereNotNull('approved_at')
            ->whereNull('archived_at')
            ->first();
        $presentationLogs = Resource::with('media', 'user')->where('is_presentation', true)
            ->where('course_id', $course->id)
            ->orderByDesc('created_at')
            ->limit(5)
            ->get();
        $presentationLogCount = Resource::where('is_presentation', true)
            ->where('course_id', $course->id)
            ->count();

        $newResourceLogs = collect();
        $resourcesLogs->each(function ($item, $key) use ($newResourceLogs) {
            $status = !empty($item->approved_at) ? 'approved' : (!empty($item->rejected_at) ? 'rejected' : 'for approval');
            $item->status = $status;
            $isOwner = $item->user_id == auth()->id() ? true : false;
            $item->isOwner = $isOwner;
            $item->filetype = $item->getFirstMedia() ? pathinfo($item->getFirstMediaPath(), PATHINFO_EXTENSION) : null;
            $newResourceLogs->push($item);
        });

        $newSyllabiLogs = collect();
        $syllabiLogs->each(function ($item, $key) use ($newSyllabiLogs) {
            $status = !empty($item->approved_at) ? 'approved' : (!empty($item->rejected_at) ? 'rejected' : 'for approval');
            $item->status = $status;
            $isOwner = $item->user_id == auth()->id() ? true : false;
            $item->isOwner = $isOwner;
            $item->filetype = $item->getFirstMedia() ? pathinfo($item->getFirstMediaPath(), PATHINFO_EXTENSION) : null;
            $newSyllabiLogs->push($item);
        });

        $newPresentationLogs = collect();
        $presentationLogs->each(function ($item, $key) use ($newPresentationLogs) {
            $status = !empty($item->approved_at) ? 'approved' : (!empty($item->rejected_at) ? 'rejected' : 'for approval');
            $item->status = $status;
            $isOwner = $item->user_id == auth()->id() ? true : false;
            $item->isOwner = $isOwner;
            $item->filetype = $item->getFirstMedia() ? pathinfo($item->getFirstMediaPath(), PATHINFO_EXTENSION) : null;
            $newPresentationLogs->push($item);
        });

        $course->resourceComplied = $resource ? true : false;
        $course->resourceSubmitter = $resource ? $resource->user->username : null;
        $course->resourceLogs = $newResourceLogs;
        $course->resourceLogCount = $resourcesLogCount;

        $course->complied = $syllabus ? true : false;
        $course->submitter = $syllabus ? $syllabus->user->username : null;
        $course->logs = $newSyllabiLogs;
        $course->syllabiLogCount = $syllabiLogCount;

        $course->presentationComplied = $presentation ? true : false;
        $course->presentationSubmitter = $presentation ? $presentation->user->username : null;
        $course->presentationLogs = $newPresentationLogs;
        $course->presentationLogCount = $presentationLogCount;

        $groupedLogs = collect([
            $newResourceLogs, $newSyllabiLogs, $newPresentationLogs
        ])->flatten();
        $course->courseResourceLogs = $groupedLogs->sortByDesc('created_at')->values()->take(3)->all();
        $course->totalSubmits = ($resourcesLogCount + $syllabiLogCount + $presentationLogCount);
        $course->syllabus = $syllabus ?? null;

        return $course;

        // $r = Resource::withTrashed()->get();
        // $resources = $r->map(function ($resource) use ($course) {
        //     return $resource->course_id == $course->id ? $resource : null;
        // })->reject(function ($resource) {
        //     return empty($resource);
        // });
        // $activities = $resources->map(function ($item, $key) {
        //     return $item->activities;
        // })->flatten()->sortByDesc('created_at');

        // return view('show-course', compact(['course', 'resources', 'activities']));
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
