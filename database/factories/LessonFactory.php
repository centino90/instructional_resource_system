<?php

namespace Database\Factories;

use App\Models\Course;
use App\Models\Resource;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class LessonFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $user = User::where('role_id', 4)->inRandomOrder()->limit(1)->first();
        $course = Course::where('program_id', $user->programs()->first()->id)->inRandomOrder()->limit(1)->first();

        return [
            'user_id' => $user->id,
            'course_id' => $course->id,
            'resource_id' => null, // syllabus id it came from
            'title' => $this->faker->words(3, true),
            'description' => $this->faker->paragraph()
        ];
    }
}
