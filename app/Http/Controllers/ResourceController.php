<?php

namespace App\Http\Controllers;

use App\Events\ResourceCreated;
use App\Http\Requests\StoreResourceRequest;
use App\Models\Course;
use App\Models\Resource;
use App\Models\User;
use Illuminate\Support\Str;
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
        $resources = Resource::with(['activities', 'media', 'users', 'auth', 'course'])
            ->whereRelation('course', 'program_id', '=', auth()->user()->program_id)
            ->orderByDesc('created_at')
            ->get();

        $activities = Activity::with('subject', 'causer', 'subject.media')->where('subject_type', 'App\Models\Resource')->orderByDesc('created_at')->limit(5)->get();


        // ->flatten()
        // ->sortByDesc('created_at')
        // ->take(5);

        // dd($activities->first()->subject);

        // dd(Activity::with('subject'));
        // dd(Activity::with('resource')->first());

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

        $courses = Course::where('program_id', auth()->user()->program_id)->get();

        return view('create-resource')->with([
            'resourceLists' => $request->resourceLists ?? 1,
            'notifications' => auth()->user()->unreadNotifications,
            'courses' => $courses
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
        // dd($request);
        abort_if(
            $request->user()->cannot('create', Resource::class),
            403
        );

        // course not found
        Course::where('program_id', auth()->user()->program_id)->findOrFail($request->course_id);

        try {
            $batchId = Str::uuid();
            $index = 0;
            foreach ($request->file as $file) {
                $r = Resource::create([
                    'course_id' => $request->course_id,
                    'user_id' => auth()->id(),
                    'batch_id' => $batchId,
                    'description' => $request->description[$index]
                ]);

                $r->users()->attach($r->user_id, ['batch_id' => $batchId]);

                $r->addMediaFromStream($file)
                    ->toMediaCollection();
                $index++;
            }

            if ($request->check_stay) {
                return redirect()
                    ->route('resources.create')
                    ->with('success', 'Resource was created successfully');
            }

            return redirect()
                ->route('resources.index')
                ->with('success', 'Resource was created successfully');
        } catch (\Throwable $th) {
            throw $th;
        }
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

    public function downloadAllByCourse(Request $request)
    {
        $zipFileName = Course::findOrFail($request->course_id)->title . '-files-' . time() . '.zip';
        $resources = Resource::where('course_id', $request->course_id)->get();

        $resourcesWithinCourse = $resources->map(function ($resource) use ($request) {
            return $resource->getMedia()[0];
        })->reject(function ($resource) {
            return empty($resource);
        });

        return MediaStream::create($zipFileName)
            ->addMedia($resourcesWithinCourse);
    }

    public function bulkDownload(Request $request)
    {
        if (!isset($request->resource_no)) {
            return redirect()->route('resources.index');
            // add error alert
        }

        $resources = Resource::withTrashed()->whereIn('id', $request->resource_no)
            ->whereHas('media', function ($query) {
                $query->whereNotNull('file_name');
            })->get();
        $zipFileName = auth()->user()->program->title . '-files-' . time() . '.zip';

        $resourcesWithinCourse = $resources->map(function ($resource) {
            return $resource->getMedia()[0];
        })->reject(function ($resource) {
            return empty($resource);
        });

        return MediaStream::create($zipFileName)
            ->addMedia($resourcesWithinCourse);
    }

    public function getResourcesJson(Request $request)
    {
        $resources = Resource::where('course_id', $request->course_id)->get();
        $resourceMedia = $resources->map(function ($resource) {
            return $resource->getMedia()[0];
        })->reject(function ($resource) {
            return empty($resource);
        });

        return response()->json(['resources' => $resourceMedia]);
    }
}
