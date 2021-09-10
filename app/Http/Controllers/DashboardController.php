<?php

namespace App\Http\Controllers;

use App\Models\Course;
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
        // $courses = Course::where('program_id', auth()->user()->program_id);
        $firstYearCourses = Course::where('program_id', auth()->user()->program_id)->where('year_level', 1)->with('resources')->get();
        $secondYearCourses = Course::where('program_id', auth()->user()->program_id)->where('year_level', 2)->with('resources')->get();
        $thirdYearCourses = Course::where('program_id', auth()->user()->program_id)->where('year_level', 3)->with('resources')->get();
        $fourthYearCourses = Course::where('program_id', auth()->user()->program_id)->where('year_level', 4)->with('resources')->get();

        // dd($secondYearCourses);
        return view('dashboard', compact('secondYearCourses'));
    }
}