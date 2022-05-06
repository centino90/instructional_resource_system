<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TypologyStandard;
use App\Http\Requests\StoreTypologyStandardRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TypologyStandardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $typology = TypologyStandard::first();

        return view('pages.admin.typology.index', compact('typology'));
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
}
