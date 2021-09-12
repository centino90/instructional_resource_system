<?php

namespace App\Http\Controllers;

use App\Models\Resource;
use App\Models\ResourceUser;
use Illuminate\Http\Request;

class ImportantResourceController extends Controller

{


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return ResourceUser::all();
        //DB(get_vars(0):Resource::all());
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
        //return DB::select("select * from resource_user");
        //return "Update ".$id;
        // $resource_user = ResourceUser::all();

        // $resource_user = ResourceUser::find($id);
        //$resource_user->user_id = $request->$id;

        // return ResourceUser::all('saved-resources');
        // return redirect()->route('saved-resources');

        // $resource_user = ResourceUser::find($id);
        //return view("saved-resources")->with("resource_user", $resource_user);

        return "saved-resources" . $id;
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        //$resource_user = ResourceUser::find($id);
        $resource_user = ResourceUser::all();
        return view('deleted-resources');
        //return $resource_user;

    }
}