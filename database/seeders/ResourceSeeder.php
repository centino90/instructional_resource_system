<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Resource;
use App\Models\User;
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
        $user = User::all()->first();
        $nextUser = User::all()->last();
        $faker = \Faker\Factory::create();

        Resource::factory()
            ->count(30)
            ->create();

        Resource::factory()
            ->count(2)
            ->state(new Sequence(
                [
                    'course_id' => Course::where('program_id', $nextUser->program_id)->get()->random(),
                    'user_id' => $user,
                    'batch_id' => $faker->uuid(),
                    'description' => $faker->text(50),
                    'deleted_at' => now(),
                ],
                [
                    'course_id' => Course::where('program_id', $nextUser->program_id)->get()->random(),
                    'user_id' => $user,
                    'batch_id' => $faker->uuid(),
                    'description' => $faker->text(50),
                ]
            ))
            ->create();

        foreach (Resource::withTrashed()->get() as $resource) {
            $resource->users()->attach($resource->user_id, ['batch_id' => $resource->batch_id, 'is_important' => rand(0, 1)]);
            $resource->addMedia($faker->filePath())
                ->toMediaCollection();
        }
    }
}