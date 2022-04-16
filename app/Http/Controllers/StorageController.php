<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class StorageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

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

        $file_size = 0;

        $files = collect();
        if (File::exists(storage_path("app/public/users/{$id}"))) {
            $files = collect(File::allFiles(storage_path("app/public/{$request->leftPath}")));
        }

        foreach ($files as $file) {
            $file_size += $file->getSize();
        }

        $storageSize = number_format($file_size / 1048576, 2) . ' MB';
        $fileCount = sizeof($files);
        $recentlyCreated = collect($files)->sortByDesc(function ($file) {
            return $file->getCTime();
        })->take(5);

        $deletedFiles = collect();
        $deletedFolders = collect();
        if (File::exists(storage_path("app/public/deleted/users/{$id}"))) {
            $deletedFiles = collect(File::files(storage_path("app/public/deleted/{$request->leftPath}")));
            $deletedFiles = $deletedFiles->map(function ($item, $key) {
                $item->created_at = date('m-d-Y H:i:s', $item->getCTime());
                $item->type = 'file';
                $item->name = $item->getFileName();
                $item->path = $item->getPath();
                return $item;
            });

            $deletedFolders = collect(File::directories(storage_path("app/public/deleted/{$request->leftPath}")));
            $deletedFolders = $deletedFolders->map(function ($item, $key) {
                $arr = explode('\\', $item);
                return ['path' => $item, 'created_at' => date('m-d-Y H:i:s', filectime($item)), 'name' => array_pop($arr), 'type' => 'folder'];
            });
        }
        $mergedDeleted = $deletedFiles->merge($deletedFolders)->sortByDesc('created_at');

        $recentlyDeleted = collect($deletedFiles)->sortByDesc(function ($file) {
            return $file->getCTime();
        })->take(5);

        return view('pages.my-storage', compact('user', 'storageSize', 'fileCount', 'recentlyCreated', 'deletedFiles', 'recentlyDeleted', 'mergedDeleted'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string  $path
     * @return \Illuminate\Http\Response
     */
    public function destroy($path)
    {
        dd(Storage::get($path));
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
