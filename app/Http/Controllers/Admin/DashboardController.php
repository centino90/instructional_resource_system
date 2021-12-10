<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Program;
use App\Models\Resource;
use App\Models\Role;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $programs = Program::OrderByDesc('id')->get();
        // $courses = Course::with('resources')->get();
        $members = User::whereNotIn('role_id', [Role::ADMIN])->get();
        $resources = Resource::all();

        $courseCountByProgram = collect([]);
        $totalResources = $resources->count();
        foreach ($programs as $program) {
            $courses = Course::with('resources')->where('program_id', $program->id)->get();
            $resourceCount = collect([]);
            foreach ($courses as $course) {
                $resourceCount->push($course->resources->count());
            }
            $courseCountByProgram[$program->code] = $resourceCount->sum();

        }

        $months = collect([
            "Jan" => 0, "Feb" => 0, "Mar" => 0, "Apr" => 0, "May" => 0, "Jun" => 0, "Jul" => 0, "Aug" => 0, "Sep" => 0, "Oct" => 0, "Nov" => 0, "Dec" => 0
        ]);
        $arr = collect();
        foreach ($resources as $resource) {
            $resource->month = Carbon::parse($resource->approved_at)->format('M');
            $resource->year = Carbon::parse($resource->approved_at)->format('Y');
            $arr->push($resource);
        }
        $resourcesByYear = $arr->groupBy('year');
        $currentYear = Carbon::parse(now())->format('Y');
        $resourcesThisYear = $resourcesByYear[$currentYear] ?? [];

        foreach ($resourcesThisYear as $resource) {
            foreach ($months as $month => $value) {
                if ($month == Carbon::parse($resource->approved_at)->format('M')) {
                    $months[$month] = $months[$month] + 1;
                }
            }
        };

        $totalDownloads = $resources->reduce(function ($carry, $item) {
            return $carry + $item->downloads;
        });
        $totalViews = $resources->reduce(function ($carry, $item) {
            return $carry + $item->views;
        });

        $chartedCourseCountByProgram = collect([]);
        foreach ($courseCountByProgram as $key => $value) {
            $chartedCourseCountByProgram->push(['text' => $key, 'values' => [$value]]);
        }

        return view('pages.admin.dashboard')
            ->with('programs', $programs)
            // ->with('courses', $courses)
            ->with('months', $months)
            ->with('year', $currentYear)
            ->with('months', $months->values())
            ->with('totalUploads', $resources->count())
            ->with('totalDownloads', $totalDownloads)
            ->with('totalViews', $totalViews)
            ->with('totalPrograms', $programs->count())
            ->with('totalCourses', $courses->count())
            ->with('totalInstructors', $members->count())
            ->with('courseCountByProgram', $chartedCourseCountByProgram);
    }
}
