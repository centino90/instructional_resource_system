<?php

namespace App\Policies;

use App\Models\Lesson;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Http\Response;

class LessonPolicy
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
        return true;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Lesson  $lesson
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Lesson $lesson)
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Lesson  $lesson
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Lesson $lesson)
    {
        if (!$user->belongsToProgram($lesson->course->program_id)) {
            return Response::deny('You are not allowed to update this lesson because it does not exist in your program.');
        }

        return $user->id == $lesson->user_id
            || $user->isProgramDean()
            ? Response::allow()
            : Response::deny('You are not allowed to update this lesson.');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Lesson  $lesson
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Lesson $lesson)
    {
        if (!$user->belongsToProgram($lesson->course->program_id)) {
            return Response::deny('You are not allowed to delete this lesson because it does not exist in your program.');
        }

        return $user->id == $lesson->user_id
            || $user->isProgramDean()
            ? Response::allow()
            : Response::deny('You are not allowed to delete this lesson.');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Lesson  $lesson
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Lesson $lesson)
    {
        if (!$user->belongsToProgram($lesson->course->program_id)) {
            return Response::deny('You are not allowed to restore this lesson because it does not exist in your program.');
        }

        return $user->id == $lesson->user_id
            || $user->isProgramDean()
            ? Response::allow()
            : Response::deny('You are not allowed to restore this lesson.');
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Lesson  $lesson
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Lesson $lesson)
    {
        //
    }
}
