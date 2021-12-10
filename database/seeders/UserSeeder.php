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
        User::factory()->count(14)
            ->create();

        User::factory()->count(1)
            ->state(new Sequence(
                ['role_id' => 1]
            ))
            ->create();

        foreach (User::all() as $user) {
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
