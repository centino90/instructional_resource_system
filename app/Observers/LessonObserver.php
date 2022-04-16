<?php

namespace App\Observers;

use App\Models\Lesson;

class LessonObserver
{
    /**
     * Handle the Lesson "created" event.
     *
     * @param  \App\Models\Lesson  $lesson
     * @return void
     */
    public function created(Lesson $lesson)
    {
        $auth = $lesson->user->name;

        activity()
            ->causedBy($lesson->user)
            ->performedOn($lesson)
            ->useLog('lesson-created')
            ->withProperties($lesson->getChanges())
            ->log("{$auth} created a lesson titled: {$lesson->title} ({id: $lesson->id})");
    }

    /**
     * Handle the Lesson "updated" event.
     *
     * @param  \App\Models\Lesson  $lesson
     * @return void
     */
    public function updated(Lesson $lesson)
    {
        $auth = $lesson->user->name;

        activity()
            ->causedBy($lesson->user)
            ->performedOn($lesson)
            ->useLog('lesson-updated')
            ->withProperties($lesson->getChanges())
            ->log("{$auth} updated a lesson titled: {$lesson->title} ({id: $lesson->id})");
    }

    /**
     * Handle the Lesson "deleted" event.
     *
     * @param  \App\Models\Lesson  $lesson
     * @return void
     */
    public function deleted(Lesson $lesson)
    {
        $auth = $lesson->user->name;

        activity()
            ->causedBy($lesson->user)
            ->performedOn($lesson)
            ->useLog('lesson-trashed')
            ->withProperties($lesson->getChanges())
            ->log("{$auth} trashed a lesson titled: {$lesson->title} ({id: $lesson->id})");
    }

    /**
     * Handle the Lesson "restored" event.
     *
     * @param  \App\Models\Lesson  $lesson
     * @return void
     */
    public function restored(Lesson $lesson)
    {
        $auth = $lesson->user->name;

        activity()
            ->causedBy($lesson->user)
            ->performedOn($lesson)
            ->useLog('lesson-restored')
            ->withProperties($lesson->getChanges())
            ->log("{$auth} restored a lesson titled: {$lesson->title} ({id: $lesson->id})");
    }

    /**
     * Handle the Lesson "force deleted" event.
     *
     * @param  \App\Models\Lesson  $lesson
     * @return void
     */
    public function forceDeleted(Lesson $lesson)
    {
        $auth = $lesson->user->name;

        activity()
            ->causedBy($lesson->user)
            ->performedOn($lesson)
            ->useLog('lesson-deleted')
            ->withProperties($lesson->getChanges())
            ->log("{$auth} deleted a lesson titled: {$lesson->title} ({id: $lesson->id})");
    }
}
