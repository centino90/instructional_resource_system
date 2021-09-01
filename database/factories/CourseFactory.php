<?php

namespace Database\Factories;

use App\Models\Course;
use App\Models\Program;
use Illuminate\Database\Eloquent\Factories\Factory;

class CourseFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Course::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $randomYear = rand(2000, 2020);
        return [
            'code' => $this->faker->stateAbbr,
            'title' => $this->faker->state,
            'program_id' => Program::all()->random(),
            'year_level' => rand(1, 4),
            // 'school_year' => $randomYear . '-' . ($randomYear + 1),
            'semester' => rand(1, 2),
            'term' => rand(1, 2)
        ];
    }
}