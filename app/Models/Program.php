<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Program extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['code', 'title', 'is_general'];

    public function users()
    {
        return $this->belongsToMany(User::class)
            ->withTimestamps();
    }

    public function deans()
    {
        return $this->belongsToMany(User::class)
            ->withTrashed()
            ->where('role_id', Role::PROGRAM_DEAN)
            ->withTimestamps();
    }

    public function courses()
    {
        return $this->hasMany(Course::class);
    }

    public function resources()
    {
        return $this->hasManyThrough(Resource::class, Course::class);
    }
}
