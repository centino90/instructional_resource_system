<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class AdminSettingsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'old_syllabus_year_interval' => env('OLD_SYLLABUS_YEAR_INTERVAL', 1),
            'delayed_syllabus_week_interval' => env('DELAYED_SYLLABUS_WEEK_INTERVAL', 2)
        ];
    }
}
