<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SyllabusSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_outcomes_table_no',
        'course_outcomes_row_no',
        'course_outcomes_col_no',
        'student_outcomes_table_no',
        'student_outcomes_row_no',
        'student_outcomes_col_no',
        'lesson_table_no',
        'lesson_row_no',
        'lesson_col_no'
    ];
}
