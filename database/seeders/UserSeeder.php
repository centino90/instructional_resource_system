<?php

namespace Database\Seeders;

use App\Models\Program;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::factory()->count(6)
            ->state(new Sequence(
                ['program_id' => 1, 'role_id' => 4],
                ['program_id' => 1, 'role_id' => 2],
                ['program_id' => 1, 'role_id' => 3],
                ['program_id' => 1, 'role_id' => 1],
                ['program_id' => 2, 'role_id' => 4],
                ['program_id' => 2, 'role_id' => 2],
            ))
            ->create();

        foreach (User::all() as $user) {
            foreach (Program::all() as $program) {
                $user->programs()->attach($program->id);
            }
        }
    }
}
