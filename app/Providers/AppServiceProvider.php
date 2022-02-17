<?php

namespace App\Providers;

use App\Models\Comment;
use App\Models\Resource;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use League\HTMLToMarkdown\HtmlConverter;
use League\HTMLToMarkdown\Converter\TableConverter;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Event::listen(
            'Alexusmai\LaravelFileManager\Events\Deleting',
            function ($event) {
                $items = collect($event->items());

                $items->each(function ($item, $key) {
                    $explodedDirs = explode('/', $item['path']);
                    if(!in_array('deleted', $explodedDirs)) {
                        if ($item['type'] === 'dir') {
                            File::copyDirectory(storage_path('app/public/' . $item['path']), storage_path('app/public/deleted/' . $item['path']));
                        } else {
                            Storage::disk('public')->copy($item['path'], 'deleted/' .  $item['path']);
                        }
                    }
                });
            }
        );

        Event::listen('Laravelista\Comments\Events\CommentCreated', function($event) {
            $resourceModel = Resource::findOrFail($event->comment->commentable_id);

            if(isset($event->comment->child_id)) {
                $commentedTo = User::findOrfail($event->comment->child_id);

                activity()
                ->causedBy(auth()->user())
                ->performedOn($resourceModel)
                ->log(auth()->user()->fname . ' ' . auth()->user()->lname . ' replied to ' . $commentedTo->fname . ' ' . $commentedTo->lname);
            }

            activity()
            ->causedBy(auth()->user())
            ->performedOn($resourceModel)
            ->log(auth()->user()->fname . ' ' . auth()->user()->lname . ' created a comment');
        });

        Event::listen('Laravelista\Comments\Events\CommentUpdated', function($event) {
            $resourceModel = Resource::findOrFail($event->comment->commentable_id);

            if(isset($event->comment->child_id)) {
                $commentedTo = User::findOrfail($event->comment->child_id);

                activity()
                ->causedBy(auth()->user())
                ->performedOn($resourceModel)
                ->log(auth()->user()->fname . ' ' . auth()->user()->lname . ' updated their reply to ' . $commentedTo->fname . ' ' . $commentedTo->lname);
            }

            activity()
            ->causedBy(auth()->user())
            ->performedOn($resourceModel)
            ->log(auth()->user()->fname . ' ' . auth()->user()->lname . ' updated their comment');
        });

        Event::listen('Laravelista\Comments\Events\CommentDeleted', function($event) {
            $resourceModel = Resource::findOrFail($event->comment->commentable_id);

            if(isset($event->comment->child_id)) {
                $commentedTo = User::findOrfail($event->comment->child_id);

                activity()
                ->causedBy(auth()->user())
                ->performedOn($resourceModel)
                ->log(auth()->user()->fname . ' ' . auth()->user()->lname . ' deleted their reply to ' . $commentedTo->fname . ' ' . $commentedTo->lname);
            }

            activity()
            ->causedBy(auth()->user())
            ->performedOn($resourceModel)
            ->log(auth()->user()->fname . ' ' . auth()->user()->lname . ' deleted their comment');
        });

    }
}
