<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dog extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_code',
        'course_title',
        'credit',
        'time_allotment',
        'professor',

        'course_description',
        'course_outcomes',
        'learning_outcomes',
        'learning_plan',
        'student_outputs'
    ];

    protected $casts = [
        'course_description' => 'array',
        'course_outcomes' => 'array',
        'learning_outcomes' => 'array',
        'learning_plan' => 'array',
        'student_outputs' => 'array'
    ];
}