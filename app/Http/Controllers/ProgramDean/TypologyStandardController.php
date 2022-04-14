<?php

namespace App\Http\Controllers\ProgramDean;

use App\DataTables\TypologyStandardDataTable;
use App\Http\Controllers\Controller;
use App\Models\TypologyStandard;
use App\Http\Requests\StoreTypologyStandardRequest;
use App\Http\Requests\UpdateTypologyStandardRequest;

class TypologyStandardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(TypologyStandardDataTable $dataTable)
    {
        return $dataTable->render('pages.dean.typology.index');
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
     * @param  \App\Http\Requests\StoreTypologyStandardRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTypologyStandardRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TypologyStandard  $typologyStandard
     * @return \Illuminate\Http\Response
     */
    public function show(TypologyStandard $typologyStandard)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TypologyStandard  $typologyStandard
     * @return \Illuminate\Http\Response
     */
    public function edit(TypologyStandard $typologyStandard)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateTypologyStandardRequest  $request
     * @param  \App\Models\TypologyStandard  $typologyStandard
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTypologyStandardRequest $request, TypologyStandard $typologyStandard)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TypologyStandard  $typologyStandard
     * @return \Illuminate\Http\Response
     */
    public function destroy(TypologyStandard $typologyStandard)
    {
        //
    }
}
