<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSavedResourceRequest;
use App\Models\Resource;
use Illuminate\Contracts\Debug\ExceptionHandler;
use Illuminate\Http\Request;
use PDOException;

class SavedResourceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $savedResources = auth()->user()->resources()->with(['courses', 'media'])
            ->orderByDesc('updated_at')->get();

        return view('saved-resources')->with(['resources' => $savedResources]);
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
    public function store(StoreSavedResourceRequest $request)
    {
        try {
            $resource = Resource::withTrashed()->findOrFail($request->resource_id);
            auth()->user()->resources()->attach($request->resource_id);
        } catch (\Throwable $e) {
            throw abort(404);
        }

        return redirect()->back()
            ->with([
                'status' => 'success',
                'message' => $resource->getMedia()[0]->file_name . ' was saved successfully'
            ]);
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
            $resource = Resource::findOrFail($id);
            auth()->user()->resources()->detach($id);
        } catch (\Throwable $e) {
            throw abort(404);
        }

        return redirect()->back()
            ->with([
                'status' => 'success-destroy-saved',
                'message' => $resource->getMedia()[0]->file_name . ' was unsaved successfully!',
                'resource_id' => $id
            ]);
    }
}