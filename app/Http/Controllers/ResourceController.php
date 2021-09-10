<?php

namespace App\Http\Controllers;

use App\Events\ResourceCreated;
use App\Http\Requests\StoreResourceRequest;
use App\Models\Course;
use App\Models\Resource;
use App\Models\TemporaryUpload;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Spatie\Activitylog\Models\Activity;
use Spatie\MediaLibrary\Support\MediaStream;
use ZipStream\Option\Archive as ArchiveOptions;

// use Spatie\MediaLibrary\MediaCollections\Models\Media;

class ResourceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $resources = Resource::withTrashed()->orderByDesc('created_at')->get();
        $activities = $resources->map(function ($item, $key) {
            return $item->activities;
        })->flatten()->sortByDesc('created_at')->take(5);

        // $r = Resource::find(1);
        // $r->description = 'test1';
        // $r->save();

        // $activities = Activity::all();
        // dd($activities->last()->subject->withTrashed());
        return view('resources', compact(['resources', 'activities']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        if ($request->user()->cannot('create', Resource::class)) {
            abort(403);
        }

        return view('create-resource')->with([
            'resourceLists' => $request->resourceLists ?? 1,
            'notifications' => auth()->user()->unreadNotifications
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreResourceRequest $request)
    {
        if ($request->user()->cannot('create', Resource::class)) {
            abort(403);
        }

        foreach ($request->file as $file) {
            $temporaryFile = TemporaryUpload::firstWhere('folder_name', $file);

            if ($temporaryFile) {
                $r = Resource::create([
                    'course_id' => $request->course_id,
                    'user_id' => auth()->id(),
                    'description' => $request->description
                ]);

                $r->users()->attach($r->user_id);

                $r->addMedia(storage_path('app/public/resource/tmp/' . $temporaryFile->folder_name . '/' . $temporaryFile->file_name))
                    ->toMediaCollection();
                rmdir(storage_path('app/public/resource/tmp/' . $file));

                event(new ResourceCreated($r));

                $temporaryFile->delete();
            }
        }

        if ($request->check_stay) {
            return redirect()
                ->route('resources.create')
                ->with('success', 'Resource was created successfully');
        }

        return redirect()
            ->route('resources.index')
            ->with('success', 'Resource was created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Resource $resource)
    {
        Gate::authorize('view', $resource);

        return $resource;
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Resource $resource)
    {
        try {
            Gate::authorize('delete', $resource);

            $resource->delete();
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException  $e) {

            throw abort(401);
        }

        $fileName = $resource->getMedia()[0]->file_name ?? 'unknown file';
        return redirect()->back()
            ->with([
                'status' => 'success-destroy-resource',
                'message' => $fileName . ' was deleted sucessfully!',
                'resource_id' => $resource->id
            ]);
    }

    /**
     * Download the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function download($mediaItem, Request $request)
    {
        if ($mediaItem == 'all') {
            $zipFileName = Course::findOrFail($request->course_id)->title . '-files-' . time() . '.zip';
            $resources = Resource::withTrashed()->get();

            $resourcesWithinCourse = $resources->map(function ($resource) use ($request) {
                return $resource->course_id == $request->course_id ? $resource->getMedia()[0] : null;
            })->reject(function ($resource) {
                return empty($resource);
            });

            return MediaStream::create($zipFileName)
                ->addMedia($resourcesWithinCourse);
        }

        return response()->download(
            Resource::withTrashed()->find($mediaItem)->getMedia()[0]->getPath(),
            Resource::withTrashed()->find($mediaItem)->getMedia()[0]->file_name
        );
    }
}