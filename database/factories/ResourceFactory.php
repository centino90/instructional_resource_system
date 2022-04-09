<?php

namespace Database\Factories;

use App\Models\Course;
use App\Models\Lesson;
use App\Models\Resource;
use App\Models\User;
use App\Models\Role;
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
        $randomUser = User::where('role_id', Role::INSTRUCTOR)->first();
        $course = Course::where('program_id', $randomUser->programs()->first()->id)->first();
        $subMonths = [2, 3, 4, 5, 6];
        return [
            'course_id' => $course,
            'lesson_id' => Lesson::where('course_id', $course->first()->id)->first(),
            'user_id' => $randomUser,
            'batch_id' => $this->faker->uuid(),
            'title' => $this->faker->word(),
            'description' => $this->faker->text(50),
            'downloads' => rand(5, 500),
            'views' => rand(5, 500),
            'approved_at' => now()->subMonths($subMonths[rand(0, 4)]),
            // 'archived_at' => [now(), null][rand(0, 1)],
            // 'deleted_at' => [now(), null][rand(0, 1)]
        ];
    }
}
