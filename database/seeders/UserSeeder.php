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
        User::factory()->count(2)
            ->state(new Sequence(
                ['role_id' => Role::ADMIN],
                ['role_id' => Role::SECRETARY]
            ))
            ->create();
        foreach (User::all()->forPage(1, 2) as $user) {
            $user->programs()->attach(Program::all()->pluck('id'));
        }

        User::factory()->count(2)
            ->state(new Sequence(
                ['role_id' => Role::PROGRAM_DEAN],
                ['role_id' => Role::INSTRUCTOR],
            ))
            ->create();
        foreach (User::all()->forPage(2, 2) as $user) {
            $user->programs()->attach(Program::all()->first()->id);
        }

        User::factory()->count(2)
            ->state(new Sequence(
                ['role_id' => Role::PROGRAM_DEAN],
                ['role_id' => Role::INSTRUCTOR],
            ))
            ->create();
        foreach (User::all()->forPage(3, 2) as $user) {
            $user->programs()->attach(Program::all()->last()->id);
        }

        User::factory()->count(2)
            ->state(new Sequence(
                ['role_id' => Role::PROGRAM_DEAN],
                ['role_id' => Role::INSTRUCTOR],
            ))
            ->create();
        foreach (User::all()->forPage(4, 2) as $user) {
            $programs = Program::all();
            $firstGroup  = $programs->split(2)->first();
            $user->programs()->attach($firstGroup->last()->id);
        }
    }
}
