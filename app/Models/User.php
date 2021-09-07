<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

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
        return $this->role_id == config('auth.roles.SUPER_ADMIN') ? true : false;
    }

    public function isAdmin()
    {
        return $this->role_id == config('auth.roles.ADMIN') ? true : false;
    }

    public function isSecretary()
    {
        return $this->role_id == config('auth.roles.SECRETARY') ? true : false;
    }

    public function isTeacher()
    {
        return $this->role_id == config('auth.roles.TEACHER') ? true : false;
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
}