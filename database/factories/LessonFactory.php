<?php

namespace Database\Factories;

use App\Models\Course;
use App\Models\Resource;
use App\Models\Role;
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
        $user = User::where('role_id', Role::INSTRUCTOR)->inRandomOrder()->first();
        $course = Course::whereIn('program_id', $user->programs()->pluck('id'))->inRandomOrder()->first();

        return [
            'user_id' => $user->id,
            'course_id' => $course->id,
            'resource_id' => null, // syllabus id it came from
            'title' => $this->faker->words(3, true),
            'description' => $this->faker->paragraph()
        ];
    }
}
