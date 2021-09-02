<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Resource extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'file', 'course_id', 'user_id', 'description', 'is_syllabus', 'approved_at', 'archived_at'
    ];

    public function users()
    {
        // return $this->hasOne(User::class, 'id', 'user_id');
        return $this->belongsToMany(User::class)
            ->withPivot('is_approved')
            ->withTimestamps();
    }

    public function courses()
    {
        return $this->belongsTo(Course::class, 'course_id', 'id');
    }

    public function syllabi()
    {
        return $this->hasOne(Syllabus::class);
    }
}