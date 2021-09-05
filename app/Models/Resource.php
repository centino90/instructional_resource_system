<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use \Venturecraft\Revisionable\RevisionableTrait;

class Resource extends Model implements HasMedia
{
    use HasFactory, SoftDeletes, InteractsWithMedia, RevisionableTrait;

    protected $fillable = [
        'course_id', 'user_id', 'description', 'is_syllabus', 'approved_at', 'archived_at'
    ];

    protected $revisionEnabled = true;
    protected $historyLimit = 500; //Maintain a maximum of 500 changes at any point of time, while cleaning up old revisions.
    protected $revisionCleanup = true; //Remove old revisions (works only when used with $historyLimit)

    protected $revisionForceDeleteEnabled = true;
    protected $revisionCreationsEnabled = true;
    protected $revisionFormattedFieldNames = [
        // 'title'      => 'Title',
        // 'small_name' => 'Nickname',
        'deleted_at' => 'deleted',
        'created_at' => 'created',
        'archived_at' => 'archived',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class)
            ->withPivot('is_important')
            ->withTimestamps();
    }

    public function courses()
    {
        return $this->belongsTo(Course::class, 'course_id', 'id');
    }

    public function syllabi()
    {
        return $this->hasOne(Syllabus::class);
    }
}