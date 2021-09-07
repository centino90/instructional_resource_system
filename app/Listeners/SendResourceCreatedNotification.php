<?php

namespace App\Listeners;

use App\Events\ResourceCreated;
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
        $admins = User::whereHas('role', function ($query) use ($event) {
            $query->where('id', 1)->where('program_id', $event->resource->course->program_id);
        })->get();

        Notification::send($admins, new NewResourceNotification($event->resource));
    }
}