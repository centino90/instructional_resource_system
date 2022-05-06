<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\User;
use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Course::factory()->count(30)->create();

        foreach (Course::all() as $course) {
            $user = User::whereHas('programs', function ($query) use ($course) {
                $query->where('program_id', $course->program_id);
            })->instructors()->inRandomOrder()->first();

            $rand = rand(1, 3);

            if ($user) {
                if ($rand == 1) {
                    $course->users()->syncWithPivotValues($user->id, ['view' => true, 'participate' => true]);
                } else if ($rand  == 2) {
                    $course->users()->syncWithPivotValues($user->id, ['view' => true, 'participate' => false]);
                } else {
                    $course->users()->syncWithPivotValues($user->id, ['view' => false, 'participate' => false]);
                }
            }
        }
    }
}
