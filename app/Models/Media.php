<?php

namespace App\Models;

use App\Scopes\MediaScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\MediaLibrary\MediaCollections\Models\Media as BaseMedia;

class Media extends BaseMedia
{
    use HasFactory;

    protected static function booted()
    {
        static::addGlobalScope(new MediaScope);
    }

    // CUSTOM
    public function getCustomName()
    {
        return 'acd-' . $this->created_at . '-' . $this->file_name;
    }

    public function resource()
    {
        return $this->belongsTo(Resource::class, 'model_id');
    }
}
