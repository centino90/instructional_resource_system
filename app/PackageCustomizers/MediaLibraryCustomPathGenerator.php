<?php

namespace App\PackageCustomizers;

use App\Models\Resource;
use App\Models\User;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\MediaLibrary\Support\PathGenerator\PathGenerator;

class MediaLibraryCustomPathGenerator implements PathGenerator
{
    public function getPath(Media $media): string
    {
        if ($media->model_type === Resource::class) {
            $resource = Resource::withTrashed()->findOrFail($media->model_id);

            return 'courses/' . $resource->course->code . '/' . $media->id . '/';
        }

        if ($media->model_type === User::class) {
            $user = User::withTrashed()->findOrFail($media->model_id);

            return 'users/' . $user->id . '/'. $media->id . '/';
        }

        return $media->id;
    }

    public function getPathForConversions(Media $media): string
    {
        return $this->getPath($media) . 'conversions/';
    }

    public function getPathForResponsiveImages(Media $media): string
    {
        return $this->getPath($media) . 'responsive/';
    }
}
