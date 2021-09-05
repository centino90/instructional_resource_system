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
        $message = 'all resources were restored successfully';
        try {
            if ($id === 'all') {
                auth()->user()->resources()->withTrashed()->restore();
            } else {
                $resource = auth()->user()->resources()->withTrashed()
                    ->findOrFail($id);
                $resource->restore();

                $message = $resource->getMedia()[0]->file_name . ' was restored successfully';
            }
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException  $e) {

            throw abort(401);
        }

        return redirect()->back()
            ->with([
                'status' => 'success',
                'message' => $message
            ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $message = 'all resources were permanently deleted';
        try {
            if ($id === 'all') {
                foreach (auth()->user()->resources()->onlyTrashed()->get() as $resource) {
                    auth()->user()->resources()->detach($resource->id);
                };

                auth()->user()->resources()->onlyTrashed()->forceDelete();
            } else {
                abort_if(auth()->user()->role_id != 1, 401);

                $r = Resource::onlyTrashed()->findOrFail($id);
                auth()->user()->resources()->detach($id);

                $message = $r->getMedia()[0]->file_name . ' was permanently deleted successfully';
                $r->forceDelete();
            }
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException  $e) {

            throw abort(401);
        }

        return redirect()->back()
            ->with([
                'status' => 'success',
                'message' => $message
            ]);
    }
}