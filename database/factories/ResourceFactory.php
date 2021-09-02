<?php

namespace Database\Factories;

use App\Models\Course;
use App\Models\Resource;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ResourceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Resource::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'course_id' => Course::all()->random(),
            'user_id' => User::all()->random(),
            'description' => $this->faker->text(50),
            'approved_at' => [now(), null][rand(0, 1)],
            'archived_at' => [now(), null][rand(0, 1)],
            'deleted_at' => [now(), null][rand(0, 1)]
        ];
    }
}