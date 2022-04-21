<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminSettings extends Model
{
    use HasFactory;

    protected $fillable = [
        'old_syllabus_year_interval',
        'delayed_syllabus_week_interval'
    ];
}
