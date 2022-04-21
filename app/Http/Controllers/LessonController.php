<?php

namespace App\Http\Controllers;

use App\DataTables\Course\LessonResourcesDataTable;
use App\DataTables\LessonsDataTable;
use App\DataTables\ResourcesDataTable;
use App\Models\Lesson;
use App\Http\Requests\StoreLessonRequest;
use App\Http\Requests\UpdateLessonRequest;
use App\Models\Course;
use App\Models\Resource;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;

use function PHPUnit\Framework\isNull;

class LessonController extends Controller
{

    public function __construct()
    {
        // $this->authorizeResource(Lesson::class, 'lesson');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(LessonsDataTable $dataTable)
    {
        // return $dataTable->render('pages.');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreLessonRequest $request)
    {
        if ($request->mode == 'old') {
            $createRoute = 'resource.createOld';
        } else {
            $createRoute = 'resource.create';
        }

        if (in_array(matchUrlToRoute()->action['as'], ['course.show'])) {
            if ($lesson = Lesson::find($request->title)) {
                return redirect()->route($createRoute, $lesson->id);
            }

            $lesson = Lesson::create(['user_id' => auth()->id()] + $request->validated());
            return redirect()->route($createRoute, $lesson->id);
        } else {
            $lesson = Lesson::create(['user_id' => auth()->id()] + $request->validated());

            return redirect()->back()->with([
                'subjectInstructor' => $lesson->user_id,
                'subjectLesson' => $lesson->id,
                'updatedSubject' => $lesson->id,
                'status' => 'success',
                'message' => "Lesson ({$lesson->title}) was successfully created"
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(LessonResourcesDataTable $dataTable, Lesson $lesson)
    {
        $lesson = Lesson::withTrashed()->findOrFail($lesson->id);

        return $dataTable->render('pages.lesson-show', compact('lesson'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Lesson $lesson)
    {
        return view('pages.lesson-edit', compact('lesson'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateLessonRequest $request, Lesson $lesson)
    {
        $lesson->update([
            'title' => $request->title,
            'description' => $request->description
        ]);
        $message = $lesson->title . '\'s fields were successfully updated!';

        return redirect()->back()
            ->with([
                'subjectInstructor' => $lesson->user_id,
                'subjectLesson' => $lesson->id,
                'updatedSubject' => $lesson->id,
                'status' => 'success',
                'message' => $message
            ]);
    }

    public function archive(Lesson $lesson)
    {
        if (!empty($lesson->archived_at)) {
            $message = $lesson->title . ' was successfully removed from archive!';
            $lesson->update([
                'archived_at' => null
            ]);
        } else {
            $message = $lesson->title . ' was successfully archived!';
            $lesson->update([
                'archived_at' => now()
            ]);
        }

        return redirect()->back()
            ->with([
                'subjectInstructor' => $lesson->user_id,
                'subjectLesson' => $lesson->id,
                'updatedSubject' => $lesson->id,
                'status' => 'success',
                'message' => $message
            ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $lesson = Lesson::withTrashed()->findOrFail($id);

        if ($lesson->trashed()) {
            $message = $lesson->title . ' was successfully restored!';
            $lesson->restore();
        } else {
            $message = $lesson->title . ' was successfully trashed!';
            $lesson->delete();
        }

        return redirect()->back()
            ->with([
                'subjectInstructor' => $lesson->user_id,
                'subjectLesson' => $lesson->id,
                'updatedSubject' => $lesson->id,
                'status' => 'success',
                'message' => $message
            ]);
    }
}
