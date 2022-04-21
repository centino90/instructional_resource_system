<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Course extends Model
{
    const DEFAULT_OLD_SYLLABUS_YEAR_INTERVAL = 1;

    use HasFactory, SoftDeletes;

    protected $fillable = [
        'code', 'title', 'year_level', 'program_id', 'semester', 'term', 'archived_at', 'current_course_outcomes',
        'current_learning_outcomes',
        'current_lessons'
    ];

    protected $casts = [
        'current_course_outcomes' => 'array',
        'current_learning_outcomes' => 'array',
        'current_lessons' => 'array',
    ];

    protected static function booted()
    {
        // static::created(function ($user) {
        //     Storage::makeDirectory("users/{$user->id}");
        // });
    }

    private function diffInYearsWithLeaps($startDate, $endDate)
    {
        return "floor((cast(date_format({$startDate},'%Y%m%d') as int) - cast(date_format({$endDate},'%Y%m%d') as int)/10000)";
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

    public function scopeOldSyllabi($query)
    {
        return $query->whereHas('resources', function ($query) {
            return $query->where('is_syllabus', true)->whereHas('media', function ($query) {
                return $query->whereRaw('ABS(CEILING(DATEDIFF(created_at, CURRENT_DATE()) / 365)) >= ?', [env('OLD_SYLLABUS_YEAR_INTERVAL', self::DEFAULT_OLD_SYLLABUS_YEAR_INTERVAL)]);
            });
        });
    }

    public function scopeUpdatedSyllabi($query)
    {
        return $query->whereHas('resources', function ($query) {
            return $query->where('is_syllabus', true)->whereHas('media', function ($query) {
                return $query->whereRaw('ABS(CEILING(DATEDIFF(created_at, CURRENT_DATE()) / 365)) < ?', [env('OLD_SYLLABUS_YEAR_INTERVAL', self::DEFAULT_OLD_SYLLABUS_YEAR_INTERVAL)]);
            });
        });
    }

    public function scopeWithoutSyllabi($query)
    {
        return $query->whereDoesntHave('resources', fn ($query) => $query->where('is_syllabus', true));
    }

    public function scopeWithSyllabi($query)
    {
        return $query->whereHas('resources', fn ($query) => $query->where('is_syllabus', true));
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

    public function getHasSyllabiAttribute()
    {
        return $this->syllabi()->count() > 0;
    }

    public function getSyllabiStatusAttribute()
    {
        $status = 'Updated';

        if (!$this->getHasSyllabiAttribute()) {
            return $status = 'No Syllabus';
        }

        if ($this->getHasOldSyllabiAttribute()) {
            return $status = 'Old';
        }

        return $status;
    }

    public function getHasOldSyllabiAttribute()
    {
        return $this->syllabi()->first()
            ->current_media_version->created_at->diffInYears(now()) >= env('OLD_SYLLABUS_YEAR_INTERVAL');
    }

    public function getHasLessonsAttribute()
    {
        return $this->lessons()->count() > 0;
    }

    // relationships

    public function lessons()
    {
        return $this->hasMany(Lesson::class);
    }

    public function resources()
    {
        return $this->hasMany(Resource::class);
    }

    public function syllabi()
    {
        return $this->hasMany(Resource::class)
            ->latest()
            ->where('is_syllabus', true);
    }

    public function program()
    {
        return $this->belongsTo(Program::class);
    }
}
