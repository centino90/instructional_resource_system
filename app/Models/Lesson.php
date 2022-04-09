<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Lesson extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'course_id',
        'resource_id',
        'title',
        'description',
        'archived_at'
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
        RELATIONSHIPS
    */

    public function resources()
    {
        return $this->hasMany(Resource::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function user()
    {
        return $this->belongsTo(Course::class);
    }
}
