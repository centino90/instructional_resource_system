<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Syllabus extends Model
{
    use HasFactory;

    protected $primaryKey = 'resource_id';

    protected $fillable = [
        'resource_id',
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

    protected $hidden = [
        'resource_id'
    ];

    public function resources()
    {
        return $this->belongsTo(Resource::class);
    }
}