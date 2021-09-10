<?php

namespace App\Http\Controllers;

use App\Models\Resource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

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
                Gate::authorize(
                    'restore',
                    auth()->user()->resources()->onlyTrashed()->first()
                );

                auth()->user()->resources()->onlyTrashed()->restore();

                $sessionMessage = 'all resources were restored successfully';
            } else {
                $resource = auth()->user()->resources()->onlyTrashed()
                    ->findOrFail($id);
                Gate::authorize('restore', $resource);

                $mediaFileName = $resource->getMedia()[0]->file_name ?? 'unknown file';
                $sessionMessage = $mediaFileName . ' was restored successfully';

                $resource->restore();
            }
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException  $e) {

            throw abort(401);
        }

        return redirect()->back()
            ->with([
                'status' => 'success',
                'message' => $sessionMessage
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
        abort_if(!auth()->user()->resources()->onlyTrashed()->first(), 404);
        try {
            if ($id === 'all') {
                $sessionMessage = 'all resources were permanently deleted';

                foreach (auth()->user()->resources()->onlyTrashed()->get() as $resource) {
                    Gate::authorize('forceDelete', $resource);

                    auth()->user()->resources()->detach($resource->id);
                };

                auth()->user()->resources()->onlyTrashed()->forceDelete();
            } else {
                $resource = Resource::onlyTrashed()->findOrFail($id);
                Gate::authorize('forceDelete', $resource);

                auth()->user()->resources()->detach($resource->id);

                $mediaFileName = $resource->getMedia()[0]->file_name ?? 'unknown file';
                $sessionMessage = $mediaFileName . ' was permanently deleted successfully';

                $resource->forceDelete();
            }
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException  $e) {

            throw $e;
        }

        return redirect()->back()
            ->with([
                'status' => 'success',
                'message' => $sessionMessage
            ]);
    }
}