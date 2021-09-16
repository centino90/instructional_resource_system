<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
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
        'program_id',
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

    public function isSuperAdmin()
    {
        return $this->role_id == Role::SUPER_ADMIN;
    }

    public function isAdmin()
    {
        return $this->role_id == Role::ADMIN;
    }

    public function isSecretary()
    {
        return $this->role_id == Role::SECRETARY;
    }

    public function isTeacher()
    {
        return $this->role_id == Role::TEACHER;
    }

    /*
    |--------------------------------------------------------------------------
    | Local Scopes
    |--------------------------------------------------------------------------
    |
    | ...
    |
    */

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

    public function program()
    {
        return $this->belongsTo(Program::class);
    }
}