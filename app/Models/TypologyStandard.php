<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypologyStandard extends Model
{
    use HasFactory;

    protected $fillable = ['verbs', 'enabled'];

    protected $casts = [
        'verbs' => 'array'
    ];
}
