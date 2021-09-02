<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreResourceRequest;
use App\Models\Resource;
use App\Models\TemporaryUpload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
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
        return view('resources');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        return view('create-resource')->with([
            'resourceLists' => $request->resourceLists ?? 1
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
        foreach ($request->file as $file) {
            $temporaryFile = TemporaryUpload::where('folder_name', $file)->first();

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
    public function show($id)
    {
        //
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
    public function destroy($id)
    {
        try {
            auth()->user()->resources()->withTrashed()
                ->where('resources.user_id', auth()->id())
                ->findOrFail($id)
                ->delete();
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException  $e) {

            throw abort(401);
        }

        return redirect()->back()
            ->with([
                'success-destroyed-resource' => 'resource was deleted successfully', 'resource_id' => $id
            ]);
    }

    /**
     * Download the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function download($mediaItem)
    {
        return response()->download(
            Resource::withTrashed()->find($mediaItem)->getMedia()[0]->getPath(),
            Resource::withTrashed()->find($mediaItem)->getMedia()[0]->file_name
        );
    }
}