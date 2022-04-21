<?php

namespace Database\Seeders;

use App\Models\AdminSettings;
use Illuminate\Database\Seeder;

class AdminSettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        AdminSettings::factory()->count(1)->create();
    }
}
