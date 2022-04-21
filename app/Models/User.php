<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use Spatie\Activitylog\Traits\CausesActivity;
use Laravelista\Comments\Commenter;
use phpDocumentor\Reflection\Types\Parent_;
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
        // 'program_id',
        'role_id'
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

    /*
    |--------------------------------------------------------------------------
    | Check Roles
    |--------------------------------------------------------------------------
    |
    | ...
    |
    */



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

    // public function belongsToProgram($programId)
    // {
    //     return $this->whereHas('programs', function (Builder $query) use($programId) {
    //         $query->where(['program_id' => $programId, 'user_id' => auth()->id()]);
    //     })->exists();
    // }

    // public function getProgramsByUser($user = auth()->user())
    // {
    //     return $this->select('program_id')->wh
    // }

    /*
    |--------------------------------------------------------------------------
    | Local Scopes
    |--------------------------------------------------------------------------
    |
    | ...
    |
    */
    // public function scopeBelongsToProgram($programId)
    // {
    //     return $this->whereHas('programs', function (Builder $query) use($programId) {
    //         $query->where(['program_id' => $programId, 'user_id' => auth()->id()]);
    //     });
    // }
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
        return $this->belongsTo(Program::class);
    }

    public function programs()
    {
        return $this->belongsToMany(Program::class)
            ->withTimestamps();
    }

    public function activityLogs()
    {
        return $this->hasMany(Activity::class, 'causer_id');
    }
}
