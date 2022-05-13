<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\Management\Admin\UserDataTable;
use App\Http\Controllers\Controller;
use App\Models\Program;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(UserDataTable $dataTable, Request $request)
    {
        return $dataTable->with('storeType', $request->storeType)->render('pages.admin.users.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $deanPrograms = Program::whereDoesntHave('deans')->get();
        $programs = Program::all();

        $roles = Role::all()->except(Role::ADMIN);

        return view('pages.admin.users.create', compact('programs', 'deanPrograms', 'roles'));
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
            'fname' => 'required|string',
            'lname' => 'required|string',
            'contact_no' => 'nullable|integer',
            'email' => 'nullable|email|unique:users',
            'program_id' => 'required|string',
            'role_id' => 'required|string',
            'storage_size' => 'required|integer'
        ]);

        $randomStr = "auto" . Str::uuid();

        $user = User::create([
            'username'  => $randomStr,
            'password' => Hash::make($randomStr),
            'temp_password' => $randomStr
        ] + $validated);

        if (in_array($validated['role_id'], [Role::SECRETARY])) {
            $user->programs()->attach(Program::all()->pluck('id'));
        } else {
            if ($validated['program_id']) {
                $user->programs()->attach($validated['program_id']);
            }
        }

        return redirect()->back()->with([
            'status' => 'success',
            'message' => 'User was successfully created',
            'updatedSubject' => $user->id
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        $programs = Program::all();
        $roles = Role::all()->except(Role::ADMIN);
        $deanPrograms = Program::whereDoesntHave('deans')->get();
        return view('pages.admin.users.edit', compact('programs', 'roles', 'user', 'deanPrograms'));
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
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'fname' => 'required|string',
            'lname' => 'required|string',
            'contact_no' => 'nullable|integer',
            'email' => 'nullable|email|unique:users,email,' . $user->id,
            'program_id' => 'required|string',
            'role_id' => 'required|string',
            'storage_size' => 'required|integer'
        ]);

        $user->update($validated);

        if (in_array($validated['role_id'], [Role::SECRETARY])) {
            $user->programs()->syncWithoutDetaching(Program::all()->pluck('id'));
        } else {
            if ($validated['program_id']) {
                $user->programs()->detach();
                $user->programs()->attach($validated['program_id']);
            }
        }

        return redirect()->back()->with([
            'status' => 'success',
            'message' => 'User was successfully updated',
            'updatedSubject' => $user->id
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
        $user = User::withTrashed()->findOrFail($id);

        // if ($user->lessons->isNotEmpty() || $user->lessons->isNotEmpty()) {
        //     return redirect()->back()
        //         ->with([
        //             'status' => 'fail',
        //             'message' => 'User cannot be trashed since he/she has lessons or resources',
        //             'updatedSubject' => $user->id
        //         ]);
        // }

        if ($user->trashed()) {
            $user->restore();
            $message = 'User was successfully restored';
        } else {
            $user->delete();
            $message = 'User was successfully trashed';
        }

        return redirect()->back()->with([
            'status' => 'success',
            'message' => $message,
            'updatedSubject' => $user->id
        ]);
    }

    public function resetPassword(Request $request, User $user)
    {
        $newPass = 'auto' . Str::uuid();
        $user->update(['temp_password' => $newPass, 'password' => Hash::make($newPass)]);

        return redirect()->back()->with([
            'status' => 'success',
            'message' => 'User Password was successfully reset',
            'updatedSubject' => $user->id
        ]);
    }
}
