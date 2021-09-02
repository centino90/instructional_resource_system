<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSavedResourceRequest;
use App\Models\Resource;
use Illuminate\Http\Request;

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
        auth()->user()->resources()->attach($request->resource_id);
        return redirect()->back()
            ->with(['success' => 'resource was restored from unsaved resources successfully']);
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
        auth()->user()->resources()->detach($id);
        return redirect()->back()
            ->with([
                'success-destroyed-saved' => 'resource was removed from saved resources successfully', 'resource_id' => $id
            ]);
    }
}