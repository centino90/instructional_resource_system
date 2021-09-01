<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            ProgramSeeder::class,
            RoleSeeder::class,
            UserSeeder::class,
            CourseSeeder::class,
            ResourceSeeder::class,
            // DogSeeder::class,
            // SyllabusSeeder::class
        ]);
    }
}