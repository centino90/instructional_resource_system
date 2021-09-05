<?php

namespace Database\Seeders;

use App\Models\Resource;
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
        $faker = \Faker\Factory::create();

        Resource::factory()
            ->count(30)
            ->create();

        foreach (Resource::withTrashed()->get() as $resource) {
            $resource->users()->attach($resource->user_id, ['is_important' => rand(0, 1)]);
            $resource->addMedia($faker->filePath())
                ->toMediaCollection();
        }
    }
}