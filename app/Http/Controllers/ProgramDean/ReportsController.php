<?php

namespace App\Http\Controllers\ProgramDean;

use App\DataTables\Reports\CourseDataTable;
use App\DataTables\Reports\CourseSubmissionsDataTable;
use App\DataTables\Reports\InstructorActivitiesDataTable;
use App\DataTables\Reports\InstructorDataTable;
use App\DataTables\Reports\SubmissionsDataTable;
use App\DataTables\Reports\SyllabusMonitoringDataTable;
use App\DataTables\ReportsResourcesDataTable;
use App\DataTables\ResourcesDataTable;
use App\DataTables\SyllabusReportsDataTable;
use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Media;
use App\Models\Resource;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;

class ReportsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $specifiedDate = $request->specifiedDate ?? now();

        $submissions = Resource::whereHas('course', function (Builder $query) {
            return $query->whereIn('program_id', auth()->user()->programs->pluck('id'));
        })->get();

        $specifiedByDay = $submissions->filter(function ($resource) use ($specifiedDate) {
            return $resource->created_at->isSameDay($specifiedDate);
        });

        return view('pages.dean.reports', compact('submissions', 'specifiedByDay'));
    }

    public function submissions(SubmissionsDataTable $dataTable, Request $request)
    {
        $startDate = !empty($request->start_date) ? Carbon::make($request->start_date)->endOfDay() : now()->subYear(1)->endOfDay();
        $endDate = !empty($request->end_date) ? Carbon::make($request->end_date)->endOfDay() : now()->endOfDay();
        $yearLevel = $request->year_level ? [$request->year_level] : [1, 2, 3, 4];
        $semester = $request->semester ? [$request->semester] : [1, 2, 3];
        $term = $request->term ? [$request->term] : [1, 2];

        $courses = Course::whereIn('program_id', auth()->user()->programs->pluck('id'))
            ->whereIn('year_level', $yearLevel)
            ->whereIn('semester', $semester)
            ->whereIn('term', $term)
            ->orderBy('title')
            ->get();

        $course = $request->course ? [$request->course] : $courses->pluck('id');

        $submissions = Resource::with(['course', 'media'])->whereHas('course', function (Builder $query) use ($yearLevel, $semester, $term, $course) {
            return $query
                ->whereIn('program_id', auth()->user()->programs->pluck('id'))
                ->whereIn('year_level', $yearLevel)
                ->whereIn('semester', $semester)
                ->whereIn('term', $term)
                ->whereIn('id', $course);
        })
            ->withCount('media')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->get();

        $byTypes = collect([
            'regular' => collect([]),
            'syllabus' => collect([]),
            'presentation' => collect([]),
        ]);
        foreach ($submissions as $key => $submission) {
            $byTypes[$submission->resource_type]->push($submission);
        }

        return $dataTable->with('storeType', $request->storeType)->render('pages.dean.reports.submissions', compact('byTypes', 'submissions', 'byTypes', 'courses'));
    }

    public function courses(CourseDataTable $dataTable, Request $request)
    {
        $startDate = !empty($request->start_date) ? Carbon::make($request->start_date)->endOfDay() : now()->subYear(1)->endOfDay();
        $endDate = !empty($request->end_date) ? Carbon::make($request->end_date)->endOfDay() : now()->endOfDay();
        $yearLevel = $request->year_level ? [$request->year_level] : [1, 2, 3, 4];
        $semester = $request->semester ? [$request->semester] : [1, 2, 3];
        $term = $request->term ? [$request->term] : [1, 2];

        $courses = Course::with('resources', 'resources.media', 'resources.user', 'lessons')
            ->withCount(['resources', 'lessons'])
            ->whereIn('program_id', auth()->user()->programs->pluck('id'))
            ->whereIn('year_level', $yearLevel)
            ->whereIn('semester', $semester)
            ->whereIn('term', $term)
            ->orderBy('title')
            ->get();

        $course = $request->course ? [$request->course] : $courses->pluck('id');

        $withSyllabi = $courses->filter(fn ($value) => $value->has_syllabi);
        $withoutSyllabi = $courses->filter(fn ($value) => !$value->has_syllabi);
        $withLessons = $courses->filter(fn ($value) => $value->has_lessons);
        $withoutLessons = $courses->filter(fn ($value) => !$value->has_lessons);

        $updatedSyllabi = $withSyllabi->filter(fn ($value) => !$value->has_old_syllabi);
        $oldSyllabi = $withSyllabi->filter(fn ($value) => $value->has_old_syllabi);

        $totalCourse = $courses->count();

        $totalSubmissions = $courses->sum('resources_count');
        $totalLessons = $courses->sum('lessons_count');
        $totalInstructorsContributed = $courses->sum('lessons_count');

        $resourceAuthors = $courses->map(function ($course) {
            return $course->resources->map(function ($resource) {
                return $resource->user;
            })->all();
        })->flatten()->unique();
        $lessonAuthors = $courses->map(function ($course) {
            return $course->lessons->map(function ($lesson) {
                return $lesson->user;
            })->all();
        })->flatten()->unique();

        return $dataTable->with('storeType', $request->storeType)
            ->render('pages.dean.reports.courses', compact(
                'courses',
                'withSyllabi',
                'withoutSyllabi',
                'withLessons',
                'withoutLessons',
                'updatedSyllabi',
                'oldSyllabi',
                'totalCourse',
                'totalSubmissions',
                'totalLessons',
                'resourceAuthors',
                'lessonAuthors'
            ));
    }

    public function syllabus(SyllabusMonitoringDataTable $dataTable, Request $request)
    {
        $startDate = !empty($request->start_date) ? Carbon::make($request->start_date)->endOfDay() : now()->subYear(1)->endOfDay();
        $endDate = !empty($request->end_date) ? Carbon::make($request->end_date)->endOfDay() : now()->endOfDay();
        $yearLevel = $request->year_level ? [$request->year_level] : [1, 2, 3, 4];
        $semester = $request->semester ? [$request->semester] : [1, 2, 3];
        $term = $request->term ? [$request->term] : [1, 2];

        $courses = Course::whereIn('program_id', auth()->user()->programs->pluck('id'))
            ->whereIn('year_level', $yearLevel)
            ->whereIn('semester', $semester)
            ->whereIn('term', $term)
            ->orderBy('title')
            ->get();
        $course = request()->get('course') ? [request()->get('course')] : $courses->pluck('id');

        $submissions = Resource::where('is_syllabus', true)->whereHas('course', function (Builder $query) {
            return $query->whereIn('program_id', auth()->user()->programs->pluck('id'));
        })
            ->whereBetween('created_at', [$startDate, $endDate])
            ->get();

        $delayedSubmissions = $submissions->filter(function ($submission) {
            return $submission->is_delayed;
        });
        $ontimeSubmissions = $submissions->filter(function ($submission) {
            return !$submission->is_delayed;
        });

        return $dataTable->with('storeType', $request->storeType)->render('pages.dean.reports.syllabus', compact('submissions', 'courses', 'delayedSubmissions', 'ontimeSubmissions'));
    }

    public function instructors(InstructorActivitiesDataTable $dataTable, Request $request)
    {
        $activityTypes = Activity::select('log_name')->groupBy('log_name')->get()->filter(fn ($log) => !collect(['user-created', 'file-deleted'])->contains($log->log_name));

        $startDate = !empty($request->start_date) ? Carbon::make($request->start_date)->endOfDay() : now()->subYear(1)->endOfDay();
        $endDate = !empty($request->end_date) ? Carbon::make($request->end_date)->endOfDay() : now()->endOfDay();

        $activities = Activity::whereIn('causer_id', auth()->user()->programs()->first()->users()->instructors()->pluck('id'))
            ->whereIn('log_name', $activityTypes)
            ->whereBetween('created_at', [$startDate, $endDate])->get();

        $fiveMostActiveInstructors = auth()->user()->programs()->first()->users()->instructors()->distinct('id')
            ->with(['activityLogs' => function ($query) use ($activityTypes, $startDate, $endDate) {
                return $query->whereIn('log_name', $activityTypes)->whereBetween('created_at', [$startDate, $endDate]);
            }])
            ->whereHas('activityLogs', function (Builder $query) use ($activityTypes, $startDate, $endDate) {
                return $query->whereIn('log_name', $activityTypes)->whereBetween('created_at', [$startDate, $endDate]);
            })
            ->limit(5)->get()->unique('id');

        $fiveMostActiveSubmitters = auth()->user()->programs()->first()->users()->instructors()->distinct('id')
            ->with(['activityLogs' => function ($query) use ($startDate, $endDate) {
                $query->where('log_name', 'resource-created')->whereBetween('created_at', [$startDate, $endDate]);
            }])
            ->whereHas('activityLogs', function (Builder $query) use ($startDate, $endDate) {
                return $query->where('log_name', 'resource-created')->whereBetween('created_at', [$startDate, $endDate]);
            })
            ->limit(5)->get()->unique('id');

        $submissionsActivities = $activities->where('log_name', 'resource-created');

        $activeInstructors = User::whereHas(
            'programs',
            fn ($query) => $query->whereIn('id', auth()->user()->programs->pluck('id'))
        )
            ->with('resources', 'lessons', 'activityLogs')
            ->withCount(['resources', 'lessons', 'activityLogs'])
            ->instructors()
            ->orderByDesc('resources_count')
            ->get();

        return $dataTable->with('storeType', $request->storeType)->render('pages.dean.reports.instructors', compact('activeInstructors', 'fiveMostActiveSubmitters', 'fiveMostActiveInstructors', 'submissionsActivities', 'activities', 'activityTypes'));
    }

    public function instructorsTable(InstructorDataTable $dataTable, Request $request)
    {
        return $dataTable->render('pages.dean.reports.instructors');
    }



    // public function courses(Request $request)
    // {
    //     $specifiedDate = $request->specifiedDate ?? now();

    //     $submissions = Resource::where('is_syllabus', true)->whereHas('course', function (Builder $query) {
    //         return $query->whereIn('program_id', auth()->user()->programs->pluck('id'));
    //     })->get();

    //     $specifiedByDay = $submissions->filter(function ($resource) use ($specifiedDate) {
    //         return $resource->created_at->isSameDay($specifiedDate);
    //     });

    //     return view('pages.dean.submissions-syllabus', compact('submissions', 'specifiedByDay'));
    // }


    public function lessons(Request $request)
    {
        $specifiedDate = $request->specifiedDate ?? now();

        $submissions = Resource::where('is_syllabus', true)->whereHas('course', function (Builder $query) {
            return $query->whereIn('program_id', auth()->user()->programs->pluck('id'));
        })->get();

        $specifiedByDay = $submissions->filter(function ($resource) use ($specifiedDate) {
            return $resource->created_at->isSameDay($specifiedDate);
        });

        return view('pages.dean.submissions-syllabus', compact('submissions', 'specifiedByDay'));
    }
}
