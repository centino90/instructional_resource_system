<?php

namespace App\Http\Controllers;

use App\DataTables\ResourcesDataTable;
use App\Models\Course;
use App\Models\Program;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\DataTables;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ResourcesDataTable $dataTable)
    {
        if (auth()->user()->isAdmin()) {
            return view('pages.admin.dashboard');
        }

        $courses = Course::whereIn('program_id', auth()->user()->programs()->pluck('id'))
            ->with('resources')
            ->get()
            ->sortBy(['year_level', 'semester', 'term', 'title'])
            ->groupBy('year_level');

        $firstYear = $courses[1] ?? [];
        $secondYear = $courses[2] ?? [];
        $thirdYear = $courses[3] ?? [];
        $fourthYear = $courses[4] ?? [];

        // ->groupBy(['year_level', function ($item) {
        //     return $item['semester'];
        // }], $preserveKeys = false);


        // return view('pages.instructor.dashboard', compact('firstYear', 'secondYear', 'thirdYear', 'fourthYear'));
        return $dataTable
            ->render('pages.instructor.dashboard', compact('firstYear', 'secondYear', 'thirdYear', 'fourthYear'));
    }

    public function resourceDatatable(ResourcesDataTable $dataTable)
    {
        return $dataTable
            ->render('welcome');
    }
}
