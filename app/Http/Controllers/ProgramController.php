<?php

namespace App\Http\Controllers\Admin;

<<<<<<< HEAD:app/Http/Controllers/Admin/InstructorsController.php
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class InstructorsController extends Controller
=======
use App\Models\Program;
use Illuminate\Http\Request;

class ProgramController extends Controller
>>>>>>> week-5-ansit:app/Http/Controllers/ProgramController.php
{
    public function __construct()
    {
        $this->authorizeResource(Program::class, 'program');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        echo 'hello';
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
<<<<<<< HEAD:app/Http/Controllers/Admin/InstructorsController.php
    public function show($id)
=======
    public function show(Program $program)
>>>>>>> week-5-ansit:app/Http/Controllers/ProgramController.php
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
<<<<<<< HEAD:app/Http/Controllers/Admin/InstructorsController.php
    public function edit($id)
=======
    public function edit(Program $program)
>>>>>>> week-5-ansit:app/Http/Controllers/ProgramController.php
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
<<<<<<< HEAD:app/Http/Controllers/Admin/InstructorsController.php
    public function update(Request $request, $id)
=======
    public function update(Request $request, Program $program)
>>>>>>> week-5-ansit:app/Http/Controllers/ProgramController.php
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
<<<<<<< HEAD:app/Http/Controllers/Admin/InstructorsController.php
    public function destroy($id)
=======
    public function destroy(Program $program)
>>>>>>> week-5-ansit:app/Http/Controllers/ProgramController.php
    {
        //
    }
}
