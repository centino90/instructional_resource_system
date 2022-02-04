<?php

namespace App\Http\Controllers;

use App\Models\ResourceDownloads;
use App\Http\Requests\StoreResourceDownloadsRequest;
use App\Http\Requests\UpdateResourceDownloadsRequest;

class ResourceDownloadsController extends Controller
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
     * @param  \App\Http\Requests\StoreResourceDownloadsRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreResourceDownloadsRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ResourceDownloads  $resourceDownloads
     * @return \Illuminate\Http\Response
     */
    public function show(ResourceDownloads $resourceDownloads)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ResourceDownloads  $resourceDownloads
     * @return \Illuminate\Http\Response
     */
    public function edit(ResourceDownloads $resourceDownloads)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateResourceDownloadsRequest  $request
     * @param  \App\Models\ResourceDownloads  $resourceDownloads
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateResourceDownloadsRequest $request, ResourceDownloads $resourceDownloads)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ResourceDownloads  $resourceDownloads
     * @return \Illuminate\Http\Response
     */
    public function destroy(ResourceDownloads $resourceDownloads)
    {
        //
    }
}
