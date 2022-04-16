<?php

namespace App\Http\Controllers\ProgramDean;

use App\DataTables\ReportsInstructorDataTable;
use App\DataTables\ReportsResourcesDataTable;
use App\DataTables\ResourcesDataTable;
use App\DataTables\SyllabusReportsDataTable;
use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Resource;
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

    public function submissions(ReportsResourcesDataTable $dataTable, Request $request)
    {
        $year = Carbon::make($request->year)->year ?? now()->year;
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
            ->whereYear('created_at', $year)
            ->get();

        $byTypes = collect([
            'regular' => collect([]),
            'syllabus' => collect([]),
            'presentation' => collect([]),
        ]);
        foreach ($submissions as $key => $submission) {
            $byTypes[$submission->resource_type]->push($submission);
        }

        return $dataTable->with('storeType', $request->storeType)->render('pages.dean.reports-resources', compact('byTypes', 'submissions', 'byTypes', 'courses'));
    }

    public function syllabus(SyllabusReportsDataTable $dataTable, Request $request)
    {
        $specifiedDate = $request->specifiedDate ?? now();
        $year = Carbon::make($request->year)->year ?? now()->year;
        $yearLevel = $request->year_level ? [$request->year_level] : [1, 2, 3, 4];
        $semester = $request->semester ? [$request->semester] : [1, 2, 3];
        $term = $request->term ? [$request->term] : [1, 2];

        $courses = Course::whereIn('program_id', auth()->user()->programs->pluck('id'))
            ->whereIn('year_level', $yearLevel)
            ->whereIn('semester', $semester)
            ->whereIn('term', $term)
            ->orderBy('title')
            ->get();

        $submissions = Resource::where('is_syllabus', true)->whereHas('course', function (Builder $query) {
            return $query->whereIn('program_id', auth()->user()->programs->pluck('id'));
        })->get();

        $specifiedByDay = $submissions->filter(function ($resource) use ($specifiedDate) {
            return $resource->created_at->isSameDay($specifiedDate);
        });

        return $dataTable->with('storeType', $request->storeType)->render('pages.dean.submissions-syllabus', compact('specifiedByDay', 'submissions', 'courses'));
    }

    public function instructors(ReportsInstructorDataTable $dataTable, Request $request)
    {
        $activityTypes = Activity::select('log_name')->groupBy('log_name')->get()->filter(fn ($log) => !collect(['user-created', 'file-deleted'])->contains($log->log_name));

        $year = Carbon::make($request->year)->year ?? now()->year;
        $type = $request->type ?  [$request->type] : $activityTypes;

        $activities = Activity::whereIn('causer_id', auth()->user()->programs()->first()->users()->instructors()->pluck('id'))
            ->whereIn('log_name', $type)
            ->whereYear('created_at', $year)->get();

        $fiveMostActiveInstructors = auth()->user()->programs()->first()->users()->instructors()->distinct('id')
            ->with(['activityLogs' => function ($query) use ($type, $year) {
                $query->whereIn('log_name', $type)->whereYear('created_at', $year);
            }])
            ->whereHas('activityLogs', function (Builder $query) use ($type, $year) {
                return $query->whereIn('log_name', $type)->whereYear('created_at', $year);
            })
            ->limit(5)->get()->unique('id');

        $fiveMostActiveSubmitters = auth()->user()->programs()->first()->users()->instructors()->distinct('id')
            ->with(['activityLogs' => function ($query) use ($type, $year) {
                $query->where('log_name', 'resource-created')->whereYear('created_at', $year);
            }])
            ->whereHas('activityLogs', function (Builder $query) use ($type, $year) {
                return $query->where('log_name', 'resource-created')->whereYear('created_at', $year);
            })
            ->limit(5)->get()->unique('id');

        $submissionsActivities = $activities->where('log_name', 'resource-created');

        return $dataTable->with('storeType', $request->storeType)->render('pages.dean.reports-instructors', compact('fiveMostActiveSubmitters', 'fiveMostActiveInstructors', 'submissionsActivities', 'activities', 'activityTypes'));
    }

    public function courses(Request $request)
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
