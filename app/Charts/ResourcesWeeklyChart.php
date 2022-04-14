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

class ResourcesWeeklyChart extends BaseChart
{
    /**
     * Handles the HTTP request for the given chart.
     * It must always return an instance of Chartisan
     * and never a string or an array.
     */
    public function handler(Request $request): Chartisan
    {
        $specifiedDate = Carbon::make($request->specifiedDate) ?? now();
        $weekNumber = $specifiedDate->format('W');

        $submissions = Resource::whereHas('course', function (Builder $query) {
            return $query->whereIn('program_id', auth()->user()->programs->pluck('id'));
        })->get();

        $specifiedByWeek = $submissions->filter(function ($resource) use ($specifiedDate, $weekNumber) {
            return $resource->created_at->setISODate($specifiedDate->format('Y'), $weekNumber)->isSameWeek($specifiedDate);
        });

        $groupedByDays = $specifiedByWeek->groupBy(function ($date) {
            return $date->created_at->format('d');
        })->all();

        $weekStartDate = $specifiedDate->startOfWeek(Carbon::SATURDAY)->format('Y-m-d H:i');
        $weekEndDate = $specifiedDate->endOfWeek(Carbon::SUNDAY)->format('Y-m-d H:i');
        $dd = collect(CarbonPeriod::create($weekStartDate, $weekEndDate));

        $groupedByDays = $dd->mapWithKeys(function ($periodDay) use ($groupedByDays) {
            $dayOfWeek = $periodDay->format('d');

            foreach ($groupedByDays as $key => $day) {
                if ($key == $dayOfWeek) {
                    return [$dayOfWeek => $day->count()];
                }
            }
            return [$dayOfWeek => 0];
        });

        return Chartisan::build()
            ->labels(['Saturday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Sunday'])
            ->dataset('All', $groupedByDays->values()->all());
    }
}
