<?php

namespace Database\Seeders;

use App\Models\SyllabusSetting;
use Illuminate\Database\Seeder;

class SyllabusSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        SyllabusSetting::factory()
        ->count(1)
        ->create();
    }
}
