<?php

namespace App\Listeners;

use App\Events\NotifyIfNoCourseSyllabus;
use App\Notifications\NotifyIfNoCourseSyllabusNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

class SendNotifyIfNoCourseSyllabusNotification
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(NotifyIfNoCourseSyllabus $event)
    {
        $courseUsers = $event->course->program->users()->instructors()->get();

        if ($courseUsers->count() > 0) {
            Notification::send($courseUsers, new NotifyIfNoCourseSyllabusNotification($event->course));
        }
    }
}
