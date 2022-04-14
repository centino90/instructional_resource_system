<?php

namespace App\Providers;

use App\Models\Comment;
use App\Models\Resource;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use League\HTMLToMarkdown\HtmlConverter;
use League\HTMLToMarkdown\Converter\TableConverter;
use ConsoleTVs\Charts\Registrar as Charts;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(Charts $charts)
    {
        $charts->register([
            \App\Charts\ResourcesWeeklyChart::class
        ]);
        $charts->register([
            \App\Charts\ResourcesMonthlyChart::class
        ]);
        $charts->register([
            \App\Charts\ResourcesYearlyChart::class
        ]);

        $charts->register([
            \App\Charts\OnTimeDelayedSyllabusChart::class
        ]);
        $charts->register([
            \App\Charts\CoursesWithOldSyllabusChart::class
        ]);
        $charts->register([
            \App\Charts\CoursesWithOldSyllabusChart::class
        ]);
        $charts->register([
            \App\Charts\PercentageByResourceTypeChart::class
        ]);
    }
}
