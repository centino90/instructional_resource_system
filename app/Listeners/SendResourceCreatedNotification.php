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
        $resourceProgramId = $event->resource->course->program_id;
        $admins = User::where('role_id', [Role::PROGRAM_DEAN])
            ->whereHas('programs', function (Builder $query) use ($resourceProgramId) {
                $query->where('program_id', $resourceProgramId);
            })->get() ?? [];

        Notification::send($admins, new NewResourceNotification($event->resource));
    }
}
