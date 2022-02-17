<?php

namespace App\PackageCustomizers;

use Alexusmai\LaravelFileManager\Services\ACLService\ACLRepository;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

/*
    This repository is a replacement for the default repository class
    ConfigACLRepository::class from file-manager config
*/

class FilemanagerCustomACLRepository implements ACLRepository
{
    /**
     * Get user ID
     *
     * @return mixed
     */
    public function getUserID()
    {
        return auth()->id();
    }

    /**
     * Get ACL rules list for user
     *
     * @return array
     */
    public function getRules(): array
    {
        if (empty($this->getUserID())) {
            return [];
        }

        return [
            ['disk' => 'public', 'path' => '/', 'access' => 1],
            ['disk' => 'public', 'path' => 'users', 'access' => 1],
            ['disk' => 'public', 'path' => 'users/' . $this->getUserID(), 'access' => 1],
            ['disk' => 'public', 'path' => 'users/' . $this->getUserID() . '/resources', 'access' => 1],
            ['disk' => 'public', 'path' => 'users/' . $this->getUserID() . '/*', 'access' => 2],

            ['disk' => 'public', 'path' => 'deleted', 'access' => 1],
            ['disk' => 'public', 'path' => 'deleted/users', 'access' => 1],
            ['disk' => 'public', 'path' => 'deleted/users/' . $this->getUserID(), 'access' => 1],
            ['disk' => 'public', 'path' => 'deleted/users/' . $this->getUserID() . '/resources', 'access' => 1],
            ['disk' => 'public', 'path' => 'deleted/users/' . $this->getUserID() . '/*', 'access' => 2],
        ];
    }
}
