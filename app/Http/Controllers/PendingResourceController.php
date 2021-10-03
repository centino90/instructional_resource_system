<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Resource;
use Illuminate\Http\Request;

class PendingResourceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view("pending-resources")->with('resources', auth()->user()->resources()->wherePivotIn('is_important',[0,1])->get());
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
        // $mediaItem = Resource::whereNull('approved_at')->first()->getMedia()->first();
        // $mediaItem->copy(Resource::whereNull('approved_at')->findOrFail($id));
        return view('show-pending-resource')
            ->with('resource', Resource::findOrFail($id));
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

    public function approve($id, Request $request)
    {
        $resource = Resource::whereNull('approved_at')->findOrFail($id);

        $resource->update([
            'approved_at' => now(),
            'rejected_at' => null
        ]);

        $comment = Comment::create([
            'user_id' => auth()->id(),
            'resource_id' => $id,
            'comment' => $request->comment ?? '',
            'comment_type' => $request->comment_type
        ]);

        activity()
            ->causedBy(auth()->id())
            ->performedOn($resource)
            ->log('approved');

        return redirect()->back()
            ->with('success', 'resource was successfully approved!');
    }

    public function reject($id, Request $request)
    {
        $resource = Resource::whereNull('rejected_at')->findOrFail($id);

        $resource->update([
            'rejected_at' => now(),
            'approved_at' => null
        ]);

        $comment = Comment::create([
            'user_id' => auth()->id(),
            'resource_id' => $id,
            'comment' => $request->comment,
            'comment_type' => $request->comment_type
        ]);

        activity()
            ->causedBy(auth()->id())
            ->performedOn($resource)
            ->log('rejected');

        return redirect()->back()
            ->with('success', 'resource was successfully rejected!');
    }
}
