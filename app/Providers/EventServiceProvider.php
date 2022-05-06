<?php

namespace App\Providers;

use App\Events\NotifyIfNoCourseSyllabus;
use App\Events\ResourceCreated;
use App\Listeners\SendNotifyIfNoCourseSyllabusNotification;
use App\Listeners\SendResourceCreatedNotification;
use App\Models\Lesson;
use App\Models\Resource;
use App\Observers\LessonObserver;
use App\Observers\ResourceObserver;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;
use App\Models\User;
use Error;
use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;


class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        ResourceCreated::class => [
            SendResourceCreatedNotification::class,
        ],
        NotifyIfNoCourseSyllabus::class => [
            SendNotifyIfNoCourseSyllabusNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        Resource::observe(ResourceObserver::class);
        Lesson::observe(LessonObserver::class);;

        Event::listen(
            Login::class,
            function ($event) {
                if (empty($event->user->activitiesByLogName['user-loggedin']) || $event->user->activitiesByLogName['user-loggedin']->last()->whereDay('created_at', '=', date('d'))->count() <= 0) {
                    activity()
                        ->causedBy($event->user)
                        ->useLog('user-loggedin')
                        ->performedOn($event->user)
                        ->withProperties($event->user->getChanges())
                        ->log("{$event->user->nameTag} loggedin");
                }

                session()->flash('status', 'Message');
            }
        );

        /*
            PACKAGE EVENTS
        */
        Event::listen(
            'Alexusmai\LaravelFileManager\Events\FilesUploading',
            function ($event) {
                if (auth()->user()->isStorageFull($event)) {
                    throw new Error('Error! You cannot upload anymore files. Your personal storage has reached its full capacity.');
                }
            }
        );

        Event::listen(
            'Alexusmai\LaravelFileManager\Events\Deleting',
            function ($event) {
                $items = collect($event->items());

                $items->each(function ($item, $key) {
                    $explodedDirs = explode('/', $item['path']);
                    if (!in_array('deleted', $explodedDirs)) {
                        $auth = auth()->user()->nameTag;
                        $userId = auth()->id();
                        $curtime = time();

                        $folderNames = collect(File::directories(storage_path("app/public/deleted/users/$userId")));
                        $folderNames = $folderNames->map(function ($item, $key) {
                            return pathinfo($item, PATHINFO_BASENAME);
                        });
                        $fileNames = collect(File::files(storage_path("app/public/deleted/users/$userId")));
                        $fileNames = $fileNames->map(function ($item, $key) {
                            return $item->getFileName();
                        });

                        $fileAndFolderNames = $folderNames->merge($fileNames);

                        if ($item['type'] === 'dir') {
                            $containedFiles = collect(File::allFiles(storage_path("app/public/{$item['path']}")));

                            $dirname = pathinfo($item['path'], PATHINFO_DIRNAME);
                            $basename = pathinfo($item['path'], PATHINFO_BASENAME);
                            $basename = preg_replace('/\((.*?)\)/', '', $basename);
                            $basename = preg_quote($basename);

                            $pattern = "/^{$basename}$/";
                            $matchingFiles = preg_grep($pattern, $fileAndFolderNames->toArray());

                            if (count($matchingFiles) > 0) {
                                $newPath = "{$dirname}/{$basename}-{$curtime}";
                            } else {
                                $newPath = "{$dirname}/{$basename}";
                            }

                            File::copyDirectory(storage_path('app/public/' . $item['path']), storage_path('app/public/deleted/' . $newPath));

                            activity()
                                ->causedBy(auth()->user())
                                ->useLog('folder-deleted')
                                ->withProperties(["path" => $item['path']])
                                ->log("{$auth} deleted a folder (path: {$item['path']}) with {$containedFiles->count()} files");
                        } else {
                            $dirname = pathinfo($item['path'], PATHINFO_DIRNAME);
                            $extension = pathinfo($item['path'], PATHINFO_EXTENSION) ?? '';
                            $basename = '';
                            if (Str::endsWith(basename(pathinfo($item['path'], PATHINFO_BASENAME), $extension), '.')) {
                                $basename = substr(pathinfo($item['path'], PATHINFO_BASENAME), 0, strrpos(pathinfo($item['path'], PATHINFO_BASENAME), '.'));
                            } else {
                                $basename = basename(pathinfo($item['path'], PATHINFO_BASENAME), $extension);
                            }
                            $basename = preg_replace('/\((.*?)\)/', '', $basename);
                            $basename = preg_quote($basename);

                            $pattern = "/^{$basename}$/";
                            $matchingFiles = preg_grep($pattern, $fileAndFolderNames->toArray());

                            if (!$extension) {
                                $newPath = "{$basename}-{$curtime}";
                            } else {
                                $newPath = "{$basename}-{$curtime}.{$extension}";
                            }

                            Storage::disk('public')->copy($item['path'], "deleted/users/{$userId}/{$newPath}");
                            activity()
                                ->causedBy(auth()->user())
                                ->useLog('file-deleted')
                                ->withProperties(["path" => $item['path']])
                                ->log("{$auth} deleted a file (path: {$item['path']})");
                        }
                    }
                });
            }
        );

        Event::listen('Laravelista\Comments\Events\CommentCreated', function ($event) {
            $resourceModel = Resource::findOrFail($event->comment->commentable_id);
            $auth = auth()->user()->nameTag;

            if (isset($event->comment->child_id)) {
                $commentedTo = User::findOrfail($event->comment->child_id);

                activity()
                    ->causedBy(auth()->user())
                    ->performedOn($resourceModel)
                    ->useLog('reply-created')
                    ->withProperties($event->comment->getChanges())
                    ->log("{$auth} replied to {$commentedTo->nameTag} (id: {$event->comment->id})");
            } else {
                activity()
                    ->causedBy(auth()->user())
                    ->performedOn($resourceModel)
                    ->useLog('comment-created')
                    ->withProperties($event->comment->getChanges())
                    ->log("{$auth} created a comment (id: {$event->comment->id})");
            }
        });

        Event::listen('Laravelista\Comments\Events\CommentUpdated', function ($event) {
            $resourceModel = Resource::findOrFail($event->comment->commentable_id);
            $auth = auth()->user()->nameTag;

            if (isset($event->comment->child_id)) {
                $commentedTo = User::findOrfail($event->comment->child_id);

                activity()
                    ->causedBy(auth()->user())
                    ->performedOn($resourceModel)
                    ->useLog('reply-updated')
                    ->withProperties($event->comment->getChanges())
                    ->log("{$auth} updated their reply (id: {$event->comment->id})");
            } else {
                activity()
                    ->causedBy(auth()->user())
                    ->performedOn($resourceModel)
                    ->useLog('comment-updated')
                    ->withProperties($event->comment->getChanges())
                    ->log("{$auth} updated a comment (id: {$event->comment->id})");
            }
        });

        Event::listen('Laravelista\Comments\Events\CommentDeleted', function ($event) {
            $resourceModel = Resource::findOrFail($event->comment->commentable_id);
            $auth = auth()->user()->nameTag;

            if (isset($event->comment->child_id)) {
                $commentedTo = User::findOrfail($event->comment->child_id);

                activity()
                    ->causedBy(auth()->user())
                    ->performedOn($resourceModel)
                    ->useLog('reply-deleted')
                    ->withProperties($event->comment->getChanges())
                    ->log("{$auth} deleted their reply (id: {$event->comment->id})");
            } else {
                activity()
                    ->causedBy(auth()->user())
                    ->performedOn($resourceModel)
                    ->useLog('comment-deleted')
                    ->withProperties($event->comment->getChanges())
                    ->log("{$auth} deleted their comment (id: {$event->comment->id})");
            }
        });
    }
}
