<?php

namespace App\Console\Commands;

use App\Models\resource;
use Illuminate\Console\Command;
use Venturecraft\Revisionable\Revision;

class CleanupResourceHistoriesCommand extends Command
{
    protected $signature = 'resources:cleanup-histories {field?}';

    protected $description = 'Removes all but the last 5 entries in the resource histories.
        {field : If provided, only history entries of that field are deleted}';

    private $offset;

    public function handle(): void
    {
        $baseQuery = Revision::where('revisionable_type', Resource::class);

        if ($this->argument('field')) {
            $baseQuery->where('key', $this->argument('field'));
        }

        $count = $baseQuery->count();

        if ($count === 0) {
            $this->warn(sprintf('No history entries%s found!', ($this->argument('field') ? ' for this field ' : '')));
            return;
        }

        $resourceCount = $baseQuery->groupBy('revisionable_id')->count('revisionable_id');

        $this->info(" Found $count entries across $resourceCount resources.");

        if (!$this->confirm('Are you sure you want to remove these history entries?')) {
            return;
        }

        $this->offset = (int)$this->ask('How many history entries should be kept?', 5);

        $bar = $this->output->createProgressBar($resourceCount);
        $bar->start();

        Resource::withTrashed()->has('revisionHistory')->each(function (Resource $resource) use ($bar) {
            $historyEntries = $resource->revisionHistory()->orderBy('created_at', 'desc')
                ->skip($this->offset)->take(9999999)
                ->pluck('id');

            Revision::whereIn('id', $historyEntries)->delete();
            $bar->advance();
        });

        $bar->finish();
        $this->line('');

        $this->info(" Successfully deleted $count entries.");
    }
}