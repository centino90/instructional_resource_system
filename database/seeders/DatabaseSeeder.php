<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Resource;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Sequence;
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
            // ResourceDownloadSeeder::class
            // DogSeeder::class,
            // SyllabusSeeder::class
        ]);

        // $user = User::all()->first();
        // $nextUser = User::all()->last();
        // $faker = \Faker\Factory::create();

        // Resource::factory()
        //     ->count(4)
        //     ->state(new Sequence(
        //         [
        //             'course_id' => Course::where('program_id', $nextUser->program_id)->get()->random(),
        //             'user_id' => $user,
        //             'batch_id' => $faker->uuid(),
        //             'description' => $faker->text(50),
        //             'approved_at' => [now(), null][rand(0, 1)],
        //             'archived_at' => [now(), null][rand(0, 1)],
        //             'deleted_at' => now(),
        //         ],
        //         [
        //             'course_id' => Course::where('program_id', $nextUser->program_id)->get()->random(),
        //             'user_id' => $user,
        //             'batch_id' => $faker->uuid(),
        //             'description' => $faker->text(50),
        //             'approved_at' => null,
        //             'archived_at' => null,
        //             'deleted_at' => null
        //         ]
        //     ))
        //     ->create();

        // foreach (Resource::withTrashed()->orderByDesc('created_at')->take(4)->get() as $resource) {
        //     $resource->users()->attach($resource->user_id, ['batch_id' => $resource->batch_id, 'is_important' => rand(0, 1)]);
        //     $resource->addMedia($faker->filePath())
        //         ->toMediaCollection();
        // }
    }
}
