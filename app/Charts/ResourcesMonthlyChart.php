<?php

declare(strict_types=1);

namespace App\Charts;

use Chartisan\PHP\Chartisan;
use ConsoleTVs\Charts\BaseChart;
use Illuminate\Http\Request;
use App\Models\Resource;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Database\Eloquent\Builder;

class ResourcesMonthlyChart extends BaseChart
{
    /**
     * Handles the HTTP request for the given chart.
     * It must always return an instance of Chartisan
     * and never a string or an array.
     */
    public function handler(Request $request): Chartisan
    {
        $specifiedDate = Carbon::make($request->specifiedDate) ?? now();

        $submissions = Resource::whereHas('course', function (Builder $query) {
            return $query->whereIn('program_id', auth()->user()->programs->pluck('id'));
        })->get();

        $specifiedByWeek = $submissions->filter(function ($resource) use ($specifiedDate) {
            return $resource->created_at->isSameMonth($specifiedDate);
        });

        $groupedByWeek = $specifiedByWeek->groupBy(function ($date) {
            return $date->created_at->format('W');
        })->all();

        $monthStartDate = $specifiedDate->startOfMonth()->format('Y-m-d H:i');
        $monthEndDate = $specifiedDate->endOfMonth()->format('Y-m-d H:i');
        $dd = collect(CarbonPeriod::create($monthStartDate, $monthEndDate));

        $groupedByWeek = $dd->mapWithKeys(function ($periodDay) use ($groupedByWeek) {
            $weekOfMonth = $periodDay->format('W');

            foreach ($groupedByWeek as $key => $week) {
                if ($key == $weekOfMonth) {
                    return [$weekOfMonth => $week->count()];
                }
            }
            return [$weekOfMonth => 0];
        });

        $labels = $groupedByWeek->values()->map(function($week, $index) {
            $index++;
            return 'Week ' . $index;
        });

        return Chartisan::build()
        ->labels($labels->toArray())
        ->dataset('All', $groupedByWeek->values()->all());
    }
}
