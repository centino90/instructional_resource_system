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
        if(auth()->user()->isAdmin()) {
            return view('pages.admin.dashboard');
        }

        $yearLevels = Course::whereIn('program_id', auth()->user()->programs()->pluck('id'))
            ->with('resources')
            ->get()
            ->sortBy(['year_level', 'semester', 'term', 'title'])
            ->groupBy(['year_level', function ($item) {
                return $item['semester'];
            }], $preserveKeys = false);

        return view('dashboard', compact('yearLevels'));
    }
}
