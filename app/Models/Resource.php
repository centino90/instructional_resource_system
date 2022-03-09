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
use Laravelista\Comments\Commentable;

class Resource extends Model implements HasMedia
{
    use HasFactory, SoftDeletes, InteractsWithMedia, LogsActivity, Commentable;

    protected $fillable = [
        'course_id', 'user_id', 'lesson_id', 'batch_id', 'title', 'description', 'is_syllabus', 'is_presentation', 'downloads', 'views', 'approved_at', 'rejected_at', 'archived_at'
    ];

    protected static $logAttributes = ['course_id', 'user_id', 'batch_id', 'is_syllabus'];

    protected static $recordEvents = ['deleted', 'created'];

    public function tapActivity(Activity $activity, string $eventName)
    {
        // if ($eventName != 'updated') {
        //     $activity->properties = null;
        // }
    }

    public function setDescriptionForEvent($callback)
    {
        // if ($eventName != 'updated') {
        //     $activity->properties = null;
        // }
    }



    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function users()
    {
        return $this->belongsToMany(User::class)
            ->withPivot(['batch_id', 'is_important'])
            ->withTimestamps();
    }

    public function lesson()
    {
        return $this->belongsTo(Lesson::class);
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

    // public function comments()
    // {
    //     return $this->hasMany(Comment::class);
    // }

    public function downloads()
    {
        return $this->hasMany(ResourceDownload::class);
    }

    // checks

    public function isWithinUserProgram()
    {
        return $this->whereRelation('course', 'program_id', '=', auth()->user()->program_id)->exists();
    }
}
