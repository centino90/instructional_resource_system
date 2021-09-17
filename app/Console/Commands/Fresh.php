<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class Fresh extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fresh:all';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Refreshing the database, cache, storage link and storage/app/public directory';

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
        Storage::disk('local')->deleteDirectory('public');

        $this->call('storage:link');
        $this->call('migrate:fresh', [
            '--seed' => 'default'
        ]);
        $this->call('cache:clear');
    }
}