<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Laravelista\Comments\Commentable;
use Spatie\Activitylog\Models\Activity;

use function PHPUnit\Framework\isNull;

class Resource extends Model implements HasMedia
{
    use HasFactory, SoftDeletes, InteractsWithMedia, Commentable;

    protected $fillable = [
        'course_id', 'user_id', 'lesson_id', 'resource_type_id', 'batch_id', 'title', 'description', 'is_syllabus', 'is_presentation', 'downloads', 'views', 'approved_at', 'rejected_at', 'archived_at'
    ];

    /*
        Local Scopes
    */

    public function scopeOnlyArchived($query)
    {
        return $query->whereNotNull('archived_at');
    }

    public function scopeWithoutArchived($query)
    {
        return $query->whereNull('archived_at');
    }

    /*
        Accessors
    */
    public function getArchivedAttribute()
    {
        return $this->archived_at == null ? false : true;
    }
    public function getIsDelayedAttribute()
    {
        return $this->created_at > $this->course->created_at->addWeeks(2);
    }
    public function getCurrentMediaVersionAttribute()
    {
        return $this->media->sortByDesc('order_column')->first();
    }
    public function getResourceTypeAttribute()
    {
        return $this->is_syllabus ? 'syllabus' : ($this->is_presentation ? 'presentation' : 'regular');
    }
    public function getSubmitDateAttribute()
    {
        return $this->created_at->diffForHumans();
    }
    public function getVerificationStatusAttribute()
    {
        $status = '';
        if ($this->approved_at != null) {
            $status = 'Approved';
        } else {
            $status = 'Pending';
        }

        return $status;
    }

    public function getStorageStatusAttribute()
    {
        $status = '';
        if ($this->deleted_at == null) {
            if ($this->archived_at == null) {
                $status = 'Current';
            } else {
                $status = 'Archived';
            }
        } else {
            $status = 'Trashed';
        }

        return $status;
    }

    public function getArchiveStatusAttribute()
    {
        $status = '';
        if ($this->archived_at == null) {
            $status = 'Current';
        } else {
            $status = 'Archived';
        }

        return $status;
    }

    public function getHasMultipleMediaAttribute()
    {
        return sizeof($this->getMedia()) > 1;
    }


    //  relationships

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

    public function activityLogs()
    {
        return $this->hasMany(Activity::class, 'subject_id');
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
