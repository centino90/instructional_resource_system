<?php

declare(strict_types=1);

namespace App\Charts;

use App\Models\Course;
use App\Models\Resource;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Chartisan\PHP\Chartisan;
use ConsoleTVs\Charts\BaseChart;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OnTimeDelayedSyllabusChart extends BaseChart
{
    /**
     * Handles the HTTP request for the given chart.
     * It must always return an instance of Chartisan
     * and never a string or an array.
     */
    public function handler(Request $request): Chartisan
    {
        // !! make interval week configurable in admin settings
        $year = isset($request->year) ? Carbon::make($request->year)->year : now()->year;
        $yearLevel = isset($request->year_level) ? [$request->year_level] : [1, 2, 3, 4];
        $semester = isset($request->semester) ? [$request->semester] : [1, 2, 3];
        $term = isset($request->term) ? [$request->term] : [1, 2];
        $courses = Course::whereIn('program_id', auth()->user()->programs->pluck('id'))
            ->whereIn('year_level', $yearLevel)
            ->whereIn('semester', $semester)
            ->whereIn('term', $term)
            ->orderBy('title')
            ->get();
        $course = request()->get('course') ? [request()->get('course')] : $courses->pluck('id');

        $delayedSubmissions = Resource::select('resources.*', 'resources.created_at')->whereHas('course', function (Builder $query) use ($yearLevel, $semester, $term, $course) {
            return $query
                ->whereIn('program_id', auth()->user()->programs->pluck('id'))
                ->whereIn('year_level', $yearLevel)
                ->whereIn('semester', $semester)
                ->whereIn('term', $term)
                ->whereIn('id', $course);
        })
            ->where('is_syllabus', true)
            ->whereYear('resources.created_at', $year)
            ->get()
            ->where('is_delayed', true);

        $ontimeSubmissions = Resource::select('resources.*', 'resources.created_at')->whereHas('course', function (Builder $query) use ($yearLevel, $semester, $term, $course) {
            return $query
                ->whereIn('program_id', auth()->user()->programs->pluck('id'))
                ->whereIn('year_level', $yearLevel)
                ->whereIn('semester', $semester)
                ->whereIn('term', $term)
                ->whereIn('id', $course);
                // ->whereRaw('resources.created_at < DATE_ADD(created_at, INTERVAL 2 WEEK)');
        })
            ->where('is_syllabus', true)
            ->whereYear('resources.created_at', $year)
            ->get()
            ->where('is_delayed', false);

        return Chartisan::build()
            ->labels(['Syllabus Submissions'])
            ->dataset('On Time', [$ontimeSubmissions->values()->count()])
            ->dataset('Delayed', [$delayedSubmissions->values()->count()]);
    }
}
