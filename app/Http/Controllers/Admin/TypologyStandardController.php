<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\TypologyStandardDataTable;
use App\Http\Controllers\Controller;
use App\Models\TypologyStandard;
use App\Http\Requests\StoreTypologyStandardRequest;
use App\Http\Requests\UpdateTypologyStandardRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

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
    public function store(StoreTypologyStandardRequest $request, $id)
    {
        $typology = TypologyStandard::findOrFail($id);

        $typology->update([
            'verbs' => collect($typology->verbs)
                ->put($request->checked_verb, $request->recommended_verb)
        ]);

        return redirect()->back()->with([
            'status' => 'success',
            'message' => 'a verb standard was successfully added'
        ]);
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
    public function update(Request $request, $id)
    {
        $typologyStandard = TypologyStandard::findOrFail($id);

        $collection = collect($request->all());
        $keys = $collection->filter(function ($value, $key) {
            return Str::contains($key, 'key-');
        });
        $properties = $collection->filter(function ($value, $key) {
            return Str::contains($key, 'property-');
        });

        $newVerbs = $properties->mapWithKeys(function ($value, $key) use ($keys, $properties) {
            $key = Str::replace('property-', '', $key);

            $origKeys = $keys->filter(function ($keyValue, $keyIndex) use ($key) {
                return Str::replace('key-', '', $keyIndex) == $key;
            });

            return [$origKeys->values()->first() => $value];
        });

        $typologyStandard->update([
            'verbs' => $newVerbs
        ]);

        return redirect()->back()->with([
            'status' => 'success',
            'message' => 'Verbs were successfully updated'
        ]);
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
