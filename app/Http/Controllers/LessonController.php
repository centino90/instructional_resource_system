<?php

namespace App\Http\Controllers;

use App\Models\Lesson;
use App\Http\Requests\StoreLessonRequest;
use App\Http\Requests\UpdateLessonRequest;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
class LessonController extends Controller
{

    public function __construct()
    {
        $this->authorizeResource(Lesson::class, 'lesson');
    }

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
        [$dirname, $basename, $filename] = array_values(pathinfo(url()->previous()));

        if(Str::contains($dirname, '/course')) {
            $course = Course::findOrFail(Str::before($basename, '?'));

            if($lesson = Lesson::find($request->title)) {
                return redirect()->route('resource.create', $lesson->id);
            }

            $lesson = Lesson::create(['user_id' => auth()->id()] + $request->validated());
            return redirect()->route('resource.create', $lesson->id);
        }


        dd(pathinfo(url()->previous()));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Lesson $lesson)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Lesson $lesson)
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
    public function update(Request $request, Lesson $lesson)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Lesson $lesson)
    {
        //
    }
}

