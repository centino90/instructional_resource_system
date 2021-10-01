<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'administrator_id'];

    public function users()
    {
        return $this->belongsToMany(User::class, 'id', 'program_id')
            ->withTimestamps();
    }


}
