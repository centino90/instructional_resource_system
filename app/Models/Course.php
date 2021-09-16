<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Course extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['code', 'title', 'year_level', 'program_id', 'semester', 'term', 'archived_at'];

    public function users()
    {
        return $this->belongsToMany(User::class)
            ->withTimestamps()
            // ->withPivot('is_manager')
            // ->using(CourseUser::class);
            ->withPivot('is_manager')
            ->as('course_subscriptions');
    }

    public function resources()
    {
        return $this->hasMany(Resource::class);
    }

    public function program()
    {
        return $this->belongsTo(Program::class);
    }
}