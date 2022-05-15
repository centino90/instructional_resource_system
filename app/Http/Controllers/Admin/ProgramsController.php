<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\Management\Admin\ProgramDataTable;
use App\Http\Controllers\Controller;
use App\Models\Program;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProgramsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ProgramDataTable $dataTable, Request $request)
    {
        return $dataTable->with('storeType', $request->storeType)->render('pages.admin.programs.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $deans = User::whereDoesntHave('programs')->deans()->get();

        return view('pages.admin.programs.create', compact('deans'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string',
            'code' => 'required|string',
            'is_general' => 'required|boolean',
            'program_dean' => 'required|array'
        ]);
        $validated['code'] = Str::upper($validated['code']);
        $validated['title'] = ucwords($validated['title']);

        $program = Program::create($validated);

        $program->users()->syncWithoutDetaching(User::whereIn('role_id', [Role::SECRETARY, Role::ADMIN])->get()->pluck('id'));

        if (isset($validated['program_dean'])) {
            $program->users()->syncWithoutDetaching($validated['program_dean']);
        }


        return redirect()->back()->with([
            'status' => 'success',
            'message' => 'Program was successfully created',
            'updatedSubject' => $program->id
        ]);
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
        $program = Program::findOrFail($id);
        $deans = User::whereDoesntHave('programs', function ($query) use ($id) {
            $query->where('program_id', '!=', $id);
        })->deans()->get();

        return view('pages.admin.programs.edit', compact('program', 'deans'));
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
        $program = Program::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string',
            'code' => 'required|string',
            'is_general' => 'required|boolean',
            'program_dean' => 'required|array'
        ]);
        $validated['code'] = Str::upper($validated['code']);
        $validated['title'] = ucwords($validated['title']);

        $program->update($validated);

        $assignedDeans = collect($validated['program_dean'])->filter(fn ($user) => !empty($user));

        $program->users()->detach();
        $program->users()->syncWithoutDetaching($assignedDeans->values());

        return redirect()->back()->with([
            'status' => 'success',
            'message' => 'Program was successfully updated',
            'updatedSubject' => $program->id
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $program = Program::withTrashed()->findOrFail($id);

        if ($program->courses()->exists()) {
            return redirect()->back()->with([
                'status' => 'fail',
                'message' => 'Program cannot be trashed because it contains courses',
                'updatedSubject' => $program->id
            ]);
        }

        if ($program->trashed()) {
            $program->restore();
            $message = 'Program was successfully restored';
        } else {
            $program->delete();
            $message = 'Program was successfully trashed';
        }

        return redirect()->back()->with([
            'status' => 'success',
            'message' => $message,
            'updatedSubject' => $program->id
        ]);
    }
}
