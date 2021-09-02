<?php

namespace App\Http\Controllers;

use App\Models\Resource;
use Illuminate\Http\Request;

class DeletedResourceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('deleted-resources')
            ->with(['resources' => auth()->user()->resources()->onlyTrashed()->where('resources.user_id', auth()->id())->get()]);
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
    public function store(Request $request)
    {
        //
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
        try {
            if ($id === 'all') {
                auth()->user()->resources()->withTrashed()
                    ->where('resources.user_id', auth()->id())->restore();
            } else {
                auth()->user()->resources()->withTrashed()
                    ->where('resources.user_id', auth()->id())
                    ->findOrFail($id)
                    ->restore();
            }
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException  $e) {

            throw abort(401);
        }

        return redirect()->back()
            ->with(['success' => 'resource(s) were restored from trash']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        abort_if(auth()->user()->role_id != 1, 401);

        $r = auth()->user()->resources();
        $r->detach($id);
        $r->withTrashed()->findOrFail($id)->forceDelete();

        return redirect()->back()
            ->with(['success' => 'resource was permanently deleted']);
    }
}