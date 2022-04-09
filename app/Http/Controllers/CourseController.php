<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCourseRequest;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\Program;
use App\Models\Resource;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;
use Illuminate\Support\Str;

class CourseController extends Controller
{

    public function __construct()
    {
        $this->authorizeResource(Course::class, 'course');
    }

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
        return view('pages.course-show')->with('course', $course);
    }

    public function showUserLessons(Course $course, User $user)
    {
        $lessons = $user->lessons()->where(['course_id' => $course->id])->withoutArchived()->get();
        $archivedLessons = $user->lessons()->where(['course_id' => $course->id])->onlyArchived()->get();
        $trashedLessons = $user->lessons()->where(['course_id' => $course->id])->onlyTrashed()->get();

        $userLessons = Lesson::where(['course_id' => $course->id, 'user_id' => $user->id])->get();

        return view('pages.course-user-lessons', compact('user', 'lessons', 'archivedLessons', 'trashedLessons', 'course'));
    }

    public function showLessons(Course $course)
    {
        $lessons = Lesson::where(['course_id' => $course->id])->withoutArchived()->get();
        $archivedLessons = Lesson::where(['course_id' => $course->id])->onlyArchived()->get();
        $trashedLessons = Lesson::where(['course_id' => $course->id])->onlyTrashed()->get();

        $instructors = $course->program->users()->instructors()->get();

        return view('pages.course-lessons', compact('instructors', 'lessons', 'archivedLessons', 'trashedLessons', 'course'));
    }

    public function showRecentSubmissions(Course $course)
    {
        $activities = Activity::whereHasMorph(
            'subject',
            [Resource::class],
            function (Builder $query) use($course){
                $query->where('course_id', $course->id);
            }
        )->whereIn('log_name', ['resource-created', 'resource-versioned'])->latest()->get();

        return view('pages.course-recentsubmissions', compact('activities', 'course'));
    }

    public function showMostActiveInstructors(Course $course)
    {
        $activeInstructors = $course->program->users()->instructors()->withCount('resources')->orderByDesc('resources_count')->get();

        return view('pages.course-mostactiveinstructors', compact('activeInstructors', 'course'));
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
    public function update(StoreCourseRequest $request, Course $course)
    {
        $course->update($request->validated());

        $message = 'was updated successfully!';
        return redirect()->route('courses.index')
            ->with([
                'status' => 'success',
                'message' => '[' . $request->code . '] ' . $request->title . ' ' . $message,
                'course_id' => $course->id
            ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Course $course)
    {
        $course->delete();

        $message = 'was deleted successfully!';
        return redirect()->route('courses.index')
            ->with([
                'status' => 'success',
                'message' => '[' . $course->code . '] ' . $course->title . ' ' . $message,
                'course_id' => $course->id
            ]);
    }



    // /**
    //  * Display a listing of the resource.
    //  *
    //  * @return \Illuminate\Http\Response
    //  */
    // public function index()
    // {
    //     $programs = collect();
    //     foreach (auth()->user()->programs as $program) {
    //         $programs = $programs->merge($program->id);
    //     }

    //     $courses = Course::whereIn('program_id', $programs)->orderBy('title')->get();
    //     return view('courses', compact('courses'));
    // }

    // /**
    //  * Show the form for creating a new resource.
    //  *
    //  * @return \Illuminate\Http\Response
    //  */
    // public function create()
    // {
    //     return view('create-course')
    //         ->with('programs', auth()->user()->programs);
    // }

    // /**
    //  * Store a newly created resource in storage.
    //  *
    //  * @param  \Illuminate\Http\Request  $request
    //  * @return \Illuminate\Http\Response
    //  */
    // public function store(StoreCourseRequest $request)
    // {
    //     $course =  Course::create($request->validated());

    //     $message = 'was created successfully!';
    //     return redirect()->route('courses.index')
    //         ->with([
    //             'status' => 'success',
    //             'message' => '[' . $course->code . '] ' . $course->title . ' ' . $message,
    //             'course_id' => $course->id
    //         ]);
    // }

    // /**
    //  * Display the specified resource.
    //  *
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    // public function show(Course $course)
    // {
    //     /* ON SUBMIT GENERAL */
    //     $generalLogs = Resource::with('media', 'user')->where('is_syllabus', false)->where('is_presentation', false)
    //         ->where('course_id', $course->id)
    //         ->orderByDesc('created_at')
    //         ->get();

    //     /* ON SUBMIT SYLLABUS */
    //     $syllabusLogs = Resource::with('media', 'user')->where('is_syllabus', true)
    //         ->where('course_id', $course->id)
    //         ->orderByDesc('created_at')
    //         ->get();

    //     /* ON SUBMIT PRESENTATION */
    //     $presentationLogs = Resource::with('media', 'user')->where('is_presentation', true)
    //         ->where('course_id', $course->id)
    //         ->orderByDesc('created_at')
    //         ->get();

    //     $newGeneralLogs = collect();
    //     $generalLogs->take(5)->each(function ($item, $key) use ($newGeneralLogs) {
    //         $status = !empty($item->approved_at) ? 'approved' : (!empty($item->rejected_at) ? 'rejected' : 'for approval');
    //         $item->status = $status;
    //         $isOwner = $item->user_id == auth()->id() ? true : false;
    //         $item->isOwner = $isOwner;
    //         $item->filetype = $item->getFirstMedia() ? pathinfo($item->getFirstMediaPath(), PATHINFO_EXTENSION) : null;
    //         $newGeneralLogs->push($item);
    //     });

    //     $newSyllabusLogs = collect();
    //     $syllabusLogs->take(5)->each(function ($item, $key) use ($newSyllabusLogs) {
    //         $status = !empty($item->approved_at) ? 'approved' : (!empty($item->rejected_at) ? 'rejected' : 'for approval');
    //         $item->status = $status;
    //         $isOwner = $item->user_id == auth()->id() ? true : false;
    //         $item->isOwner = $isOwner;
    //         $item->filetype = $item->getFirstMedia() ? pathinfo($item->getFirstMediaPath(), PATHINFO_EXTENSION) : null;
    //         $newSyllabusLogs->push($item);
    //     });

    //     $newPresentationLogs = collect();
    //     $presentationLogs->take(5)->each(function ($item, $key) use ($newPresentationLogs) {
    //         $status = !empty($item->approved_at) ? 'approved' : (!empty($item->rejected_at) ? 'rejected' : 'for approval');
    //         $item->status = $status;
    //         $isOwner = $item->user_id == auth()->id() ? true : false;
    //         $item->isOwner = $isOwner;
    //         $item->filetype = $item->getFirstMedia() ? pathinfo($item->getFirstMediaPath(), PATHINFO_EXTENSION) : null;
    //         $newPresentationLogs->push($item);
    //     });

    //     $course->generalLogs = $newGeneralLogs;
    //     $course->syllabusLogs = $newSyllabusLogs;
    //     $course->presentationLogs = $newPresentationLogs;

    //     $course->courseResourceLogs = collect([
    //         [$newGeneralLogs],
    //         [$newSyllabusLogs],
    //         [$newPresentationLogs]
    //     ])->flatten()->sortByDesc('created_at')->values()->take(3);

    //     $course->resourceUploads = [
    //         'total' => ($newGeneralLogs->count() + $newSyllabusLogs->count()+ $newPresentationLogs->count()),
    //         'general' => $newGeneralLogs->count(),
    //         'syllabus' => $newSyllabusLogs->count(),
    //         'presentation' => $newPresentationLogs->count()
    //     ];

    //     $course->resourceDownloads = [
    //         'total' => ($newGeneralLogs->sum('downloads') + $newSyllabusLogs->sum('downloads') + $newPresentationLogs->sum('downloads')),
    //         'general' => $newGeneralLogs->sum('downloads'),
    //         'syllabus' => $newSyllabusLogs->sum('downloads'),
    //         'presentation' => $newPresentationLogs->sum('downloads')
    //     ];

    //     $course->resourceViews = [
    //         'total' => ($newGeneralLogs->sum('views') + $newSyllabusLogs->sum('views') + $newPresentationLogs->sum('views')),
    //         'general' => $newGeneralLogs->sum('views'),
    //         'syllabus' => $newSyllabusLogs->sum('views'),
    //         'presentation' => $newPresentationLogs->sum('views')
    //     ];

    //     $course->latestSyllabus = $newSyllabusLogs->whereNotNull('approved_at')->first() ?? null;

    //     return $course;
    // }

    // /**
    //  * Show the form for editing the specified resource.
    //  *
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    // public function edit(Course $course)
    // {
    //     return view('edit-course')
    //         ->with('course', $course)
    //         ->with('programs', auth()->user()->programs);
    // }

    // /**
    //  * Update the specified resource in storage.
    //  *
    //  * @param  \Illuminate\Http\Request  $request
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    // public function update(StoreCourseRequest $request, $id)
    // {
    //     $course =  Course::find($id)->update($request->validated());

    //     $message = 'was updated successfully!';
    //     return redirect()->route('courses.index')
    //         ->with([
    //             'status' => 'success',
    //             'message' => '[' . $request->code . '] ' . $request->title . ' ' . $message,
    //             'course_id' => $id
    //         ]);
    // }

    // /**
    //  * Remove the specified resource from storage.
    //  *
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    // public function destroy($id)
    // {
    //     $course = Course::findOrFail($id);
    //     $course->delete();

    //     $message = 'was deleted successfully!';
    //     return redirect()->route('courses.index')
    //         ->with([
    //             'status' => 'success',
    //             'message' => '[' . $course->code . '] ' . $course->title . ' ' . $message,
    //             'course_id' => $id
    //         ]);
    // }
}
