<?php

namespace App\Listeners;

use App\Events\ResourceCreated;
use App\Models\Role;
use App\Models\User;
use App\Notifications\NewResourceNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

class SendResourceCreatedNotification
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(ResourceCreated $event)
    {
        $allowedRoles = collect();
        if(in_array($event->resource->user->role_id, [Role::PROGRAM_DEAN, Role::ADMIN])) {
            $allowedRoles->push(Role::INSTRUCTOR, Role::SECRETARY);
        } else {
            $allowedRoles->push(Role::PROGRAM_DEAN);
        }

        $resourceProgramId = $event->resource->course->program_id;
        $notifiableUsers = User::whereIn('role_id', $allowedRoles->all())
            ->whereHas('programs', function (Builder $query) use ($resourceProgramId) {
                $query->where('program_id', $resourceProgramId);
            })->get() ?? [];

        Notification::send($notifiableUsers, new NewResourceNotification($event->resource));
    }
}
