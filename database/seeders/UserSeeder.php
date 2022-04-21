<?php

namespace Database\Seeders;

use App\Models\Program;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
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
        User::factory()->count(4)
            ->state(new Sequence(
                ['role_id' => Role::PROGRAM_DEAN],
                ['role_id' => Role::INSTRUCTOR],
                ['role_id' => Role::ADMIN],
                ['role_id' => Role::SECRETARY]
            ))
            ->create();
        foreach (User::all() as $user) {
            $user->programs()->attach(Program::first());
        }

        User::factory()->count(10)
            ->create();

        foreach (User::whereDoesntHave('programs')->get() as $user) {
            if ($user->isAdmin() || $user->isSecretary()) {
                foreach (Program::all() as $program) {
                    $user->programs()->attach($program->id);
                }
            } else {
                $user->programs()->attach(Program::all()->random());
            }
        }
    }
}
