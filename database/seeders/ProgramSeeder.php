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
                ['title' => 'BSIT'],
                ['title' => 'BSHM'],
                ['title' => 'BSBA']
            ))
            ->create();
    }
}
