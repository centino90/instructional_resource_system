<?php

declare(strict_types=1);

namespace App\Charts;

use App\Models\Resource;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Chartisan\PHP\Chartisan;
use ConsoleTVs\Charts\BaseChart;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class SampleChart extends BaseChart
{
    /**
     * Handles the HTTP request for the given chart.
     * It must always return an instance of Chartisan
     * and never a string or an array.
     */
    public function handler(Request $request): Chartisan
    {
        $specifiedDate = $request->specifiedDate ?? now();

        $submissions = Resource::whereHas('course', function (Builder $query) {
            return $query->whereIn('program_id', auth()->user()->programs->pluck('id'));
        })->get();

        $specifiedByWeek = $submissions->filter(function ($resource) use ($specifiedDate) {
            return $resource->created_at->isSameWeek($specifiedDate);
        });

        $groupedByDays = $specifiedByWeek->groupBy(function ($date) {
            return $date->created_at->format('d');
        })->all();

        $now = Carbon::now();
        $weekStartDate = $now->startOfWeek()->format('Y-m-d H:i');
        $weekEndDate = $now->endOfWeek()->format('Y-m-d H:i');
        $dd = collect(CarbonPeriod::create($weekStartDate, $weekEndDate));

        $groupedByDays = $dd->mapWithKeys(function ($periodDay) use ($groupedByDays){
            $dayOfWeek = $periodDay->format('d');

            foreach ($groupedByDays as $key => $day) {
                if($key == $dayOfWeek) {
                    return [$dayOfWeek => $day->count()];
                }
            }
            return [$dayOfWeek => 0];
        });

        return Chartisan::build()
            ->labels(['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'])
            ->dataset('All', $groupedByDays->values()->all());
    }
}
