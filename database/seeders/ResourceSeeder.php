<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Resource;
use App\Models\User;
use App\Models\Role;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class ResourceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $user = User::where('role_id', Role::INSTRUCTOR)->get()->first();
        $nextUser = User::where('role_id', Role::INSTRUCTOR)->get()->last();
        $faker = \Faker\Factory::create();

        Resource::factory()
            ->count(5)
            ->create();

        // Resource::factory()
        //     ->count(2)
        //     ->state(new Sequence(
        //         [
        //             'course_id' => Course::where('program_id', $nextUser->programs()->first()->id)->get()->random(),
        //             'user_id' => $user,
        //             'batch_id' => $faker->uuid(),
        //             'title' => $faker->word(),
        //             'description' => $faker->text(50),
        //             'deleted_at' => now(),
        //         ],
        //         [
        //             'course_id' => Course::where('program_id', $nextUser->programs()->first()->id)->get()->random(),
        //             'user_id' => $user,
        //             'batch_id' => $faker->uuid(),
        //             'title' => $faker->word(),
        //             'description' => $faker->text(50),
        //         ]
        //     ))
        //     ->create();

        foreach (Resource::withTrashed()->get() as $resource) {
            $resource->users()->attach($resource->user_id, ['batch_id' => $resource->batch_id, 'is_important' => rand(0, 1)]);
            $resource->addMedia($faker->filePath())
                ->toMediaCollection();
        }
    }
}
