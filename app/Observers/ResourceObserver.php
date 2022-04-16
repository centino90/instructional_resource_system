<?php

namespace App\Observers;

use App\Models\Resource;

class ResourceObserver
{
    /**
     * Handle the Resource "created" event.
     *
     * @param  \App\Models\Resource  $resource
     * @return void
     */
    public function created(Resource $resource)
    {
        $auth = $resource->user->nameTag;

        activity()
            ->causedBy($resource->user)
            ->performedOn($resource)
            ->useLog('resource-created')
            ->withProperties($resource->getChanges())
            ->log("{$auth} created (resource: {$resource->title}) (id: {$resource->id})");
    }

    /**
     * Handle the Resource "updated" event.
     *
     * @param  \App\Models\Resource  $resource
     * @return void
     */
    public function updated(Resource $resource)
    {
        $auth = $resource->user->nameTag;

        if (!collect($resource->getChanges())->has('views') && !collect($resource->getChanges())->has('downloads')) {
            activity()
                ->causedBy($resource->user)
                ->performedOn($resource)
                ->useLog('resource-updated')
                ->withProperties(['original' => $resource->getOriginal(), 'changes' => $resource->getChanges()])
                ->log("{$auth} updated (resource: {$resource->title}) (id: {$resource->id})");
        }
    }

    /**
     * Handle the Resource "deleted" event.
     *
     * @param  \App\Models\Resource  $resource
     * @return void
     */
    public function deleted(Resource $resource)
    {
        $auth = $resource->user->nameTag;

        activity()
            ->causedBy($resource->user)
            ->performedOn($resource)
            ->useLog('resource-trashed')
            ->withProperties($resource->getChanges())
            ->log("{$auth} trashed (resource: {$resource->title}) (id: {$resource->id})");
    }

    /**
     * Handle the Resource "restored" event.
     *
     * @param  \App\Models\Resource  $resource
     * @return void
     */
    public function restored(Resource $resource)
    {
        $auth = $resource->user->nameTag;

        activity()
            ->causedBy($resource->user)
            ->performedOn($resource)
            ->useLog('resource-restored')
            ->withProperties($resource->getChanges())
            ->log("{$auth} restored (resource: {$resource->title}) (id: {$resource->id})");
    }

    /**
     * Handle the Resource "force deleted" event.
     *
     * @param  \App\Models\Resource  $resource
     * @return void
     */
    public function forceDeleted(Resource $resource)
    {
        $auth = $resource->user->nameTag;

        activity()
            ->causedBy($resource->user)
            ->performedOn($resource)
            ->useLog('resource-deleted')
            ->withProperties($resource->getChanges())
            ->log("{$auth} deleted (resource: {$resource->title}) (id: {$resource->id})");
    }
}
