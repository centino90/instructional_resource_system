<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResourceDownload extends Model
{
    use HasFactory;

    public function resources()
    {
        return $this->belongsTo(Resource::class);
    }
    public function users()
    {
        return $this->belongsTo(User::class);
    }
}
