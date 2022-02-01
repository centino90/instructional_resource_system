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
        return $user->belongsToProgram($resource->course->program_id)
            ? Response::allow()
            : Response::deny('This resource is not within your program.');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return $user->isInstructor() || $user->isSecretary();
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
        if (!$user->belongsToProgram($resource->course->program_id)) {
            return Response::deny('This resource cannot be updated because it does not exist in your program.');
        }

        return $user->isInstructor() && $user->id == $resource->user_id
            || $user->isSecretary()
            || $user->isProgramDean()
            ? Response::allow()
            : Response::deny('Only teachers and secretaries can update resources within their respective programs.');
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
        if (!$user->belongsToProgram($resource->course->program_id)) {
            return Response::deny('This resource cannot be temporarily deleted because it does not exist in your program.');
        }

        return $user->isProgramDean() || $user->isSecretary() || $user->id === $resource->user_id
            ? Response::allow()
            : Response::deny('Teachers who do not own this resource are not allowed to temporarily it');
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
        if (!$user->belongsToProgram($resource->course->program_id)) {
            return Response::deny('This resource cannot be restored because it does not exist in your program.');
        }

        return $user->isProgramDean() || $user->isSecretary()
            ? Response::allow()
            : Response::deny('Teachers are not allowed to restore temporarily deleted resources.');
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
        return $user->isAdmin()
            ? Resource::allow()
            : Response::deny('Only admins can permanently delete resources.');
    }
}
