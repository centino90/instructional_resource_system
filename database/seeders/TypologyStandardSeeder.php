<?php

namespace Database\Seeders;

use App\Models\TypologyStandard;
use Illuminate\Database\Seeder;

class TypologyStandardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TypologyStandard::factory()
        ->count(1)
        ->create();
    }
}
