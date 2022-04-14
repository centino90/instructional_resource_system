<?php

declare(strict_types = 1);

namespace App\Charts;

use Chartisan\PHP\Chartisan;
use ConsoleTVs\Charts\BaseChart;
use Illuminate\Http\Request;
use App\Models\Resource;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Database\Eloquent\Builder;

class ResourcesYearlyChart extends BaseChart
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
            return $resource->created_at->isSameYear($specifiedDate);
        });

        $groupedByMonth = $specifiedByWeek->groupBy(function ($date) {
            return $date->created_at->format('m');
        })->all();

        $yearStartDate = $specifiedDate->startOfYear()->format('Y-m-d H:i');
        $yearEndDate = $specifiedDate->endOfYear()->format('Y-m-d H:i');
        $dd = collect(CarbonPeriod::create($yearStartDate, $yearEndDate));

        $groupedByMonth = $dd->mapWithKeys(function ($periodDay) use ($groupedByMonth) {
            $monthOfYear = $periodDay->format('m');

            foreach ($groupedByMonth as $key => $month) {
                if ($key == $monthOfYear) {
                    return [$monthOfYear => $month->count()];
                }
            }
            return [$monthOfYear => 0];
        });

        return Chartisan::build()
        ->labels(['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'Septemer', 'October', 'November', 'December'])
        ->dataset('All', $groupedByMonth->values()->all());
    }
}
