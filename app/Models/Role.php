<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public const ADMIN = 1;
    public const PROGRAM_DEAN = 2;
    public const SECRETARY = 3;
    public const INSTRUCTOR = 4;

    public function users()
    {
        return $this->belongsToMany(User::class)
            ->withTrashed();
    }
}
