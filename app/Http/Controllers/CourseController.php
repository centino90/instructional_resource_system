<?php

namespace App\Http\Controllers;

use App\DataTables\View\AccordionResourcesDataTable;
use App\DataTables\Management\UserCourseLessonsDataTable;
use App\DataTables\View\CourseLessonsDataTable;
use App\DataTables\View\CourseResourcesDataTable;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\User;

class CourseController extends Controller
{

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(AccordionResourcesDataTable $dataTable, Course $course)
    {
        $this->authorize('view', $course);

        return $dataTable->render('pages.course-show', compact('course'));
    }

    public function showUserLessons(UserCourseLessonsDataTable $dataTable, Course $course, User $user)
    {
        $this->authorize('view', $course);
        $this->authorize('view', $user);

        $lessons = $user->lessons()->where(['course_id' => $course->id])->withoutArchived()->get();
        $archivedLessons = $user->lessons()->where(['course_id' => $course->id])->onlyArchived()->get();
        $trashedLessons = $user->lessons()->where(['course_id' => $course->id])->onlyTrashed()->get();

        $userLessons = Lesson::where(['course_id' => $course->id, 'user_id' => $user->id])->get();

        return $dataTable->render('pages.course-user-lessons', compact('user', 'lessons', 'archivedLessons', 'trashedLessons', 'course'));
    }

    public function showLessons(CourseLessonsDataTable $dataTable, Course $course)
    {
        $this->authorize('view', $course);

        return $dataTable->render('pages.course-lessons', compact('course'));
    }

    public function showResources(CourseResourcesDataTable $dataTable, Course $course)
    {
        $this->authorize('view', $course);

        return $dataTable->render('pages.course.resources', compact('course'));
    }
}
