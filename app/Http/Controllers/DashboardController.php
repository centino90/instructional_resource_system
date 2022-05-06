<?php

namespace App\Http\Controllers;

use App\Models\Course;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('view', auth()->user()->programs_with_general->all());

        if (auth()->user()->isProgramDean()) {
            $courses = Course::whereIn('program_id', auth()->user()->programs->pluck('id'))
                ->with('resources')
                ->get()
                ->sortBy(['year_level', 'semester', 'term', 'title'])
                ->groupBy('year_level');
        } else if (auth()->user()->isInstructor()) {
            $courses = auth()->user()->courses()->whereHas('users', function ($query) {
                $query->where('view', true);
            })
                ->with('resources')
                ->get()
                ->sortBy(['year_level', 'semester', 'term', 'title'])
                ->groupBy('year_level');
        } else {
            $courses = Course::with('resources')
                ->get()
                ->sortBy(['year_level', 'semester', 'term', 'title'])
                ->groupBy('year_level');
        }


        $firstYear = $courses[1] ?? collect();
        $secondYear = $courses[2] ?? collect();
        $thirdYear = $courses[3] ?? collect();
        $fourthYear = $courses[4] ?? collect();

        return view('pages.dashboard', compact('firstYear', 'secondYear', 'thirdYear', 'fourthYear'));
    }
}
