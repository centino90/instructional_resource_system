<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Models\Activity;

class Resource extends Model implements HasMedia
{
    use HasFactory, SoftDeletes, InteractsWithMedia, LogsActivity;

    protected $fillable = [
        'course_id', 'user_id', 'batch_id', 'description', 'is_syllabus', 'approved_at', 'archived_at'
    ];

    protected static $logAttributes = ['course_id', 'user_id', 'batch_id', 'is_syllabus'];

    public function tapActivity(Activity $activity, string $eventName)
    {
        // if ($eventName != 'updated') {
        //     $activity->properties = null;
        // }
    }

    public function users()
    {
        return $this->belongsToMany(User::class)
            ->withPivot(['batch_id', 'is_important'])
            ->withTimestamps();
    }

    public function auth()
    {
        return $this->belongsToMany(User::class)
            ->withPivot(['batch_id', 'is_important'])
            ->withTimestamps()
            ->wherePivot('user_id', auth()->id());
    }

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id', 'id');
    }

    public function syllabus()
    {
        return $this->hasOne(Syllabus::class);
    }

    // checks

    public function isWithinUserProgram()
    {
        return $this->whereRelation('course', 'program_id', '=', auth()->user()->program_id)->exists();
    }
}