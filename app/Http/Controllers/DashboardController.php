<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Program;
use App\Models\Role;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // dd(auth()->user()->programs);
        // $users = auth()->user()->whereHas('programs', function (Builder $query) {
        //     $query->where(['program_id' => 1, 'user_id' => auth()->id()]);
        // })->exists();
        // dd(Program::all());
        // dd(auth()->user()->programs);

        // dd(Program::whereIn('id', auth()->user()->programs()->pluck('id'))->get());

        $yearLevels = Course::whereIn('program_id', auth()->user()->programs()->pluck('id'))
            ->with('resources')
            ->get()
            ->sortBy(['year_level', 'semester', 'term', 'title'])
            ->groupBy(['year_level', function ($item) {
                return $item['semester'];
            }], $preserveKeys = false);

        // dd($yearLevels);

        // dd($secondYearCourses);
        return view('dashboard', compact('yearLevels'));
    }
}
