<?php

namespace App\Http\Controllers;

use App\Models\AdminSettings;
use App\Http\Requests\StoreAdminSettingsRequest;
use App\Http\Requests\UpdateAdminSettingsRequest;

class AdminSettingsController extends Controller
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
     * @param  \App\Http\Requests\StoreAdminSettingsRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAdminSettingsRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\AdminSettings  $adminSettings
     * @return \Illuminate\Http\Response
     */
    public function show(AdminSettings $adminSettings)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\AdminSettings  $adminSettings
     * @return \Illuminate\Http\Response
     */
    public function edit(AdminSettings $adminSettings)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateAdminSettingsRequest  $request
     * @param  \App\Models\AdminSettings  $adminSettings
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAdminSettingsRequest $request, AdminSettings $adminSettings)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AdminSettings  $adminSettings
     * @return \Illuminate\Http\Response
     */
    public function destroy(AdminSettings $adminSettings)
    {
        //
    }
}
