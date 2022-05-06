<?php

namespace App\Models;

use Illuminate\Support\Facades\File;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use Spatie\Activitylog\Traits\CausesActivity;
use Laravelista\Comments\Commenter;
use Spatie\Activitylog\Models\Activity;

class User extends Authenticatable
{
    use HasFactory, Notifiable, CausesActivity, Commenter, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'fname',
        'lname',
        'username',
        'password',
        'contact_no',
        'email',
        'role_id',
        'temp_password',
        'storage_size'
    ];

    protected $appends = ['name', 'name_tag'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    protected static function booted()
    {
        static::creating(function ($user) {
            $user->storage_size = config('app.max_personal_file_storage_size');
        });

        static::created(function ($user) {
            Storage::makeDirectory("users/{$user->id}");
            Storage::makeDirectory("deleted/users/{$user->id}");

            activity()
                ->causedBy($user)
                ->useLog('user-created')
                ->performedOn($user)
                ->withProperties($user->all())
                ->log("{$user->nameTag} is created");
        });
    }

    /*
    |--------------------------------------------------------------------------
    | Accessors
    |--------------------------------------------------------------------------
    |
    | ...
    |
    */

    public function getNameAttribute()
    {
        return "{$this->fname} {$this->lname}";
    }

    public function getNameTagAttribute()
    {
        return "{$this->fname} {$this->lname} ({$this->role->name})";
    }

    public function getActivitiesByLogNameAttribute()
    {
        return $this->activityLogs()->get()
            ->groupBy('log_name');
    }

    public function getCoursesContributedAttribute()
    {
        return $this->resources->groupBy('course_id')->count();
    }

    public function getProgramsWithGeneralAttribute()
    {
        $generalPrograms = Program::where('is_general', true)->get();

        return $this->programs->merge($generalPrograms)->unique('id');
    }

    public function getFileStorageSizeAttribute()
    {
        $defaultFileStoragePath = storage_path("app/public/users/{$this->id}");
        $deletedFileStoragePath = storage_path("app/public/deleted/users/{$this->id}");

        $file_size = 0;

        $files = collect();
        if (File::exists($defaultFileStoragePath)) {
            $files = collect(File::allFiles($defaultFileStoragePath));
        }

        foreach ($files as $file) {
            $file_size += $file->getSize();
        }

        $deletedFiles = collect();
        if (File::exists($deletedFileStoragePath)) {
            $deletedFiles = collect(File::allFiles($deletedFileStoragePath));
        }

        foreach ($deletedFiles as $file) {
            $file_size += $file->getSize();
        }

        return number_format($file_size / 1048576, 2); // in MB
    }

    /*
    |--------------------------------------------------------------------------
    | Local Scopes
    |--------------------------------------------------------------------------
    |
    | ...
    |
    */



    public function scopeAdmins($query)
    {
        return $query->where('role_id', Role::ADMIN);
    }

    public function scopeDeans($query)
    {
        return $query->where('role_id', Role::PROGRAM_DEAN);
    }

    public function scopeSecretaries($query)
    {
        return $query->where('role_id', Role::SECRETARY);
    }

    public function scopeInstructors($query)
    {
        return $query->where('role_id', Role::INSTRUCTOR);
    }

    public function scopeWithinAuthPrograms($query)
    {
        return $query->whereHas('programs', function (Builder $query) {
            $query->whereIn('program_id', auth()->user()->programs->pluck('id'));
        });
    }

    public function scopeWithinAuthGeneralPrograms($query)
    {
        if ($this->isGeneralDean(auth()->user())) {
            return $query->whereHas('programs');
        } else {
            return $query->whereHas('programs', function (Builder $query) {
                $query->whereIn('program_id', auth()->user()->programs->pluck('id'));
            });
        }
    }


    /*
    |--------------------------------------------------------------------------
    | Check Roles
    |--------------------------------------------------------------------------
    |
    | ...
    |
    */




    public function isGeneralDean(User $user)
    {
        return $user->isProgramDean()
            && $user->programs()->where('is_general', true)->exists();
    }
    public function isAdmin()
    {
        return $this->role_id == Role::ADMIN;
    }

    public function isProgramDean()
    {
        return $this->role_id == Role::PROGRAM_DEAN;
    }

    public function isSecretary()
    {
        return $this->role_id == Role::SECRETARY;
    }

    public function isInstructor()
    {
        return $this->role_id == Role::INSTRUCTOR;
    }

    public function belongsToProgram($programId)
    {
        if (!is_array($programId)) {
            $programId = Arr::add([], '0', $programId);
        }
        return $this->whereHas('programs', function (Builder $query) use ($programId) {
            $query->whereIn('program_id', $programId)
                ->where('user_id', auth()->id());
        })->exists();
    }
    public function belongsToProgramWithGeneral($programId)
    {
        if (!is_array($programId)) {
            $programId = Arr::add([], '0', $programId);
        }
        return $this->whereHas('programs', function (Builder $query) use ($programId) {
            $query->whereIn('program_id', $programId)
                ->where('user_id', auth()->id())
                ->orWhere('is_general', true);
        })->exists();
    }
    public function hasCourse($course)
    {
        return $this->courses()
            ->where('course_id', $course)
            ->exists();
    }
    public function hasCourseWithReadAccess($course)
    {
        return $this->courses()
            ->where(['course_id' => $course, 'view' => true])
            ->exists();
    }
    public function hasCourseWithWriteAccess($course)
    {
        return $this->courses()
            ->where(['course_id' => $course, 'participate' => true])
            ->exists();
    }

    public function isStorageFull(float $newVal = 0)
    {
        return ($this->file_storage_size + $newVal) >= $this->storage_size;
    }

    public function isStorageReachingFull()
    {
        return $this->file_storage_size >= $this->getSeventhyFivePercent($this->storage_size);
    }

    private function getSeventhyFivePercent($number)
    {
        return ($number / 4) * 3;
    }

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    |
    | ...
    |
    */

    public function resources()
    {
        return $this->belongsToMany(Resource::class)
            ->withPivot('is_important')
            ->withTimestamps();
    }

    public function courses()
    {
        return $this->belongsToMany(Course::class)
            ->withPivot('view', 'participate')
            ->withTimestamps();
    }

    public function lessons()
    {
        return $this->hasMany(Lesson::class);
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function program()
    {
        return $this->belongsTo(Program::class)
            ->withTrashed();
    }

    public function programs()
    {
        return $this->belongsToMany(Program::class)
            ->withTrashed()
            ->withTimestamps();
    }

    public function programsWithGeneral()
    {
        return $this->belongsToMany(Program::class)
            ->withTrashed()
            ->withTimestamps();
    }

    public function activityLogs()
    {
        return $this->hasMany(Activity::class, 'causer_id');
    }
}
