<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;


class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::factory()
            ->count(4)
            ->state(new Sequence(
                ['name' => 'ADMIN'],
                ['name' => 'PROGRAM DEAN'],
                ['name' => 'SECRETARY'],
                ['name' => 'INSTRUCTOR']
            ))
            ->create();
    }
}
