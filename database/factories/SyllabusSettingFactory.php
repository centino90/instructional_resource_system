<?php

namespace Database\Factories;

use App\Models\SyllabusSetting;
use Illuminate\Database\Eloquent\Factories\Factory;

class SyllabusSettingFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = SyllabusSetting::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'course_outcomes_table_no' => 0,
            'course_outcomes_row_no' => 0,
            'course_outcomes_col_no' => 0,
            'student_outcomes_table_no' => 0,
            'student_outcomes_row_no' => 0,
            'student_outcomes_col_no' => 0,
            'lesson_table_no' => 0,
            'lesson_row_no' => 0,
            'lesson_col_no' => 0

            //    let courseOutcomesTableNo = 1
            //    let courseOutcomesRowNo = 1
            //    let courseOutcomesColNo = 1

            //    let studLearningOutcomesTableNo = 3
            //    let studLearningOutcomesRowNo = 1
            //    let studLearningOutcomesColNo = 0

            //    let lessonTableNo = 2
            //    let lessonRowNo = 1
            //    let lessonColNo = 1
        ];
    }
}
