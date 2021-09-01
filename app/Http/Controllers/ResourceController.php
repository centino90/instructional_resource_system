<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreResourceRequest;
use App\Models\Resource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

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
    public function store(Request $request)
    {
        $resourceLists = isset($request->file) ? count($request->file) : 1;

        $validator = Validator::make($request->all(), [
            // 'resource_type.*' => 'required|string:',
            'file.*' => 'required|string',
            'course_id' => 'required|string',
            'description.*' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return redirect()->route(
                'resources.create',
                [
                    'resourceLists' => $resourceLists,
                ]
            )
                ->withErrors($validator)
                ->withInput();
        }

        $course = $request->course_id;
        $files = $request->file;
        $resource_types = $request->resource_type;
        $descriptions = $request->description;

        for ($i = 0; $i < count($files); $i++) {
            Resource::create([
                'course_id' => $course,
                'user_id' => auth()->id(),
                'file' => $files[$i],
                'description' => $descriptions[$i]
            ]);
        }

        if ($request->check_stay) {
            return redirect()
                ->route('resources.create')
                ->with('success', 'Resource was created successfully');
        }

        if ($request->tab == 'syllabus') {
            return redirect()
                ->route('resources.index', ['tab' => 'syllabus'])
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
        //
    }
}