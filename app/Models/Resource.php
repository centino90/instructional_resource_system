<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Resource extends Model implements HasMedia
{
    use HasFactory, SoftDeletes, InteractsWithMedia, LogsActivity;

    protected $fillable = [
        'course_id', 'user_id', 'description', 'is_syllabus', 'approved_at', 'archived_at'
    ];

    protected static $logFillable = true;

    public function users()
    {
        return $this->belongsToMany(User::class)
            ->withPivot('is_important')
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