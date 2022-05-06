<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class StorageController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, Request $request)
    {
        $storageIdFromPath = explode('/', $request->leftPath)[1];

        abort_if($id != auth()->id() || $storageIdFromPath != auth()->id(), 403, 'You cannot access someone\'s storage');

        $user = User::findOrFail($id);

        $files = collect();
        if (File::exists(storage_path("app/public/users/{$id}"))) {
            $files = collect(File::allFiles(storage_path("app/public/{$request->leftPath}")));
        }

        $totalFileSize = $files->reduce(function ($carry, $item) {
            return $carry + $item->getSize();
        });

        $fileCount = sizeof($files);
        $recentlyCreated = collect($files)->sortByDesc(function ($file) {
            return $file->getCTime();
        })->take(5);

        $deletedFiles = collect();
        $deletedFolders = collect();
        if (File::exists(storage_path("app/public/deleted/users/{$id}"))) {
            $deletedFiles = collect(File::files(storage_path("app/public/deleted/{$request->leftPath}")));

            $totalFileSize += $deletedFiles->reduce(function ($carry, $item) {
                return $carry + $item->getSize();
            });

            $deletedFiles = $deletedFiles->map(function ($item, $key){
                $item->created_at = date('m-d-Y H:i:s', $item->getCTime());
                $item->type = 'file';
                $item->name = $item->getFileName();
                $item->path = $item->getPath();
                return $item;
            });

            $deletedFolders = collect(File::directories(storage_path("app/public/deleted/{$request->leftPath}")));
            $deletedFolders = $deletedFolders->map(function ($item, $key) {
                $latestFile = collect(File::allFiles($item))
                    ->map(fn ($file) => date('m-d-Y H:i:s', $file->getCTime()))
                    ->sortDesc()
                    ->first();

                $arr = explode('\\', $item);
                return ['path' => $item, 'created_at' => $latestFile, 'name' => array_pop($arr), 'type' => 'folder'];
            });
        }

        $mergedDeleted = $deletedFiles->merge($deletedFolders)->sortByDesc('created_at');

        $storageSize = number_format($totalFileSize / 1048576, 2);

        $recentlyDeleted = collect($deletedFiles)->sortByDesc(function ($file) {
            return $file->getCTime();
        })->take(5);

        return view('pages.user.storage', compact('user', 'storageSize', 'fileCount', 'recentlyCreated', 'deletedFiles', 'recentlyDeleted', 'mergedDeleted'));
    }

    public function restore(Request $request)
    {
        $auth = auth()->user();
        $fileOrFolderName = pathinfo($request->path, PATHINFO_BASENAME);
        $curdate = date('m-d-Y-H-i-s');

        if (!$request->path) {
            dd('need path!');
        }

        Storage::move("deleted/users/{$auth->id}/{$fileOrFolderName}", "users/{$auth->id}/restored/{$fileOrFolderName}(r-{$curdate})");

        return redirect()->back()->with([
            'status' => 'success',
            'message' => "You successfully restored {$fileOrFolderName} renamed to {$fileOrFolderName}(r-{$curdate})"
        ]);
    }
}
