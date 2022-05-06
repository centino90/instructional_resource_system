<?php

namespace App\Policies;

use App\Models\Resource;
use App\Models\Role;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class ResourcePolicy
{
    use HandlesAuthorization;


    /**
     * Perform pre-authorization checks.
     *
     * @param  \App\Models\User  $user
     * @param  string  $ability
     * @return void|bool
     */
    public function before(User $user, $ability)
    {
        if ($user->isAdmin()) {
            return true;
        }
    }

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Resource  $resource
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Resource $resource)
    {
        return $user->belongsToProgram($resource->course->program_id) || $resource->course->program->is_general;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return $user->isInstructor() || $user->isProgramDean();
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Resource  $resource
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Resource $resource)
    {
        return $user->id == $resource->user_id
            || $user->isProgramDean() && $user->belongsToProgram($resource->course->program_id);
    }

    public function preview(User $user, Resource $resource)
    {
        return $resource->verification_status == 'Approved';
    }

    public function validate(User $user, Resource $resource)
    {
        return $resource->verification_status == 'Pending';
    }

    public function archive(User $user, Resource $resource)
    {
        return $resource->storage_status == 'Current' && $resource->verification_status == 'Approved';
    }

    public function unarchive(User $user, Resource $resource)
    {
        return $resource->storage_status == 'Archived' && $resource->verification_status == 'Approved';
    }


    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Resource  $resource
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Resource $resource)
    {
        if ($resource->getStorageStatusAttribute() != 'Approved') {
            return false;
        }

        return $user->id == $resource->user_id
            || $user->isProgramDean()
            && $user->belongsToProgram($resource->course->program_id);
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Resource  $resource
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Resource $resource)
    {
        return $user->id == $resource->user_id
            || $user->isProgramDean()
            && $user->belongsToProgram($resource->course->program_id);
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Resource  $resource
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Resource $resource)
    {
        return false;
    }
}
