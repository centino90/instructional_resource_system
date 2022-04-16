<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Course extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['code', 'title', 'year_level', 'program_id', 'semester', 'term', 'archived_at'];


    protected static function booted()
    {
        // static::created(function ($user) {
        //     Storage::makeDirectory("users/{$user->id}");
        // });
    }

    /* Accessors */
    public function getLatestSyllabusAttribute()
    {
        return $this->resources()->with('media')->where('is_syllabus', true)->first();
    }

    /* Local scope */
    public function scopeOnlyArchived($query)
    {
        return $query->whereNotNull('archived_at');
    }

    public function scopeWithoutArchived($query)
    {
        return $query->whereNull('archived_at');
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


    public function users()
    {
        return $this->belongsToMany(User::class)
            ->withTimestamps()
            // ->withPivot('is_manager')
            // ->using(CourseUser::class);
            ->withPivot('is_manager')
            ->as('course_subscriptions');
    }

    public function lessons()
    {
        return $this->hasMany(Lesson::class);
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
