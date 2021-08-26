<?php

namespace Database\Factories;

use App\Models\Resource;
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
            'resource_type' => $this->faker->word(),
            'file' => $this->faker->filePath(),
            'course_id' => $this->faker->numberBetween(1, 100),
            'description' => $this->faker->text(50)
        ];
    }
}