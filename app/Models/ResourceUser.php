<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class ResourceUser extends Pivot
{
    public function resource()
    {
        return $this->belongsTo(Resource::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}