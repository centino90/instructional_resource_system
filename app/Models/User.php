<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Arr;
use Spatie\Activitylog\Traits\CausesActivity;

class User extends Authenticatable
{
    use HasFactory, Notifiable, CausesActivity;

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
        if(!is_array($programId)) {
            $programId = Arr::add([], '0', $programId);
        }
        return $this->whereHas('programs', function (Builder $query) use($programId) {
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
}
