<?php

namespace Database\Seeders;

use App\Models\ResourceDownload;
use Illuminate\Database\Seeder;

class ResourceDownloadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ResourceDownload::factory()
        ->count(150)
        ->create();
    }
}
