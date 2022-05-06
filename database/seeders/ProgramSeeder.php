<?php

namespace Database\Seeders;

use App\Models\Program;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class ProgramSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Program::factory()
            ->count(3)
            ->state(new Sequence(
                ['code' => 'BSIT', 'title' => 'Bachelor of Science in Information Technology', 'is_general' => false],
                ['code' => 'BSHM', 'title' => 'Bachelor of Science in Hospitality Management', 'is_general' => false],
                ['code' => 'GE', 'title' => 'General Education', 'is_general' => true]
            ))
            ->create();
    }
}
