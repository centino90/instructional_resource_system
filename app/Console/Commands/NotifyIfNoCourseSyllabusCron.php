<?php

namespace App\Console\Commands;

use App\Events\NotifyIfNoCourseSyllabus;
use App\Models\Course;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class NotifyIfNoCourseSyllabusCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notify:no-syllabus';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $courses = Course::whereDoesntHave('resources', fn(\Illuminate\Database\Eloquent\Builder $query) => $query->where('is_syllabus', true))->get();

        if($courses->count() > 0) {
            foreach ($courses as $course) {
                NotifyIfNoCourseSyllabus::dispatch($course);
            }
        }

        return Command::SUCCESS;
    }
}
