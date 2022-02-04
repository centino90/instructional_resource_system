<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    use HasFactory;

    protected $fillable = ['code', 'title'];

    public function users()
    {
        return $this->belongsToMany(User::class)
            ->withTimestamps();
    }

    public function courses()
    {
        return $this->hasMany(Course::class);
    }


}
