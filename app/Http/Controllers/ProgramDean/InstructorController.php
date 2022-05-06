<?php

namespace App\Http\Controllers\ProgramDean;

use App\DataTables\Management\Dean\InstructorsDataTable;
use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class InstructorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(InstructorsDataTable $dataTable, Request $request)
    {
        return $dataTable->with('storeType', $request->storeType)
            ->render('pages.dean.instructors.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $courses = Course::whereIn('program_id', auth()->user()->programs->pluck('id'))->get();

        return view('pages.dean.instructors.create', compact('courses'));
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
            'email' => 'nullable|email',
            'write' => 'nullable|array',
            'read' => 'nullable|array'
        ]);

        $randomStr = "auto" . Str::uuid();

        $user = User::create([
            'role_id' => Role::INSTRUCTOR,
            'username'  => $randomStr,
            'password' => Hash::make($randomStr),
            'temp_password' => $randomStr
        ] + $validated);

        $user->programs()->attach(auth()->user()->programs->pluck('id'));

        $assignedCoursesByRead = collect($validated['read'])->filter(fn ($read) => boolval($read));
        $assignedCoursesByWrite = collect($validated['write'])->filter(fn ($write) => boolval($write));
        $mergedAssignedCourses = $assignedCoursesByRead->union($assignedCoursesByWrite);

        $user->courses()->syncWithoutDetaching($mergedAssignedCourses->keys());

        if (!empty($validated['read'])) {
            $unAssignedCourses = collect($validated['read'])->filter(fn ($read) => !boolval($read));

            $user->courses()->updateExistingPivot($assignedCoursesByRead->keys(), ['view' => true]);
            $user->courses()->updateExistingPivot($unAssignedCourses->keys(), ['view' => false]);
        }

        if (!empty($validated['write'])) {
            $unAssignedCourses = collect($validated['write'])->filter(fn ($write) => !boolval($write));

            $user->courses()->updateExistingPivot($assignedCoursesByWrite->keys(), ['participate' => true]);
            $user->courses()->updateExistingPivot($unAssignedCourses->keys(), ['participate' => false]);
        }

        return redirect()->back()->with([
            'status' => 'success',
            'message' => 'Instructor was successfully created',
            'updatedSubject' => $user->id
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
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $instructor = User::withinAuthGeneralPrograms()->instructors()->findOrFail($id);
        $courses = Course::whereIn('program_id', auth()->user()->programs->pluck('id'))->get();

        return view('pages.dean.instructors.edit', compact('instructor', 'courses'));
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
        $user = User::withinAuthPrograms()->instructors()->findOrFail($id);

        $validated = $request->validate([
            'fname' => 'required|string',
            'lname' => 'required|string',
            'contact_no' => 'nullable|integer',
            'email' => 'nullable|email',
            'write' => 'nullable|array',
            'read' => 'nullable|array'
        ]);
        $user->update($validated);

        $assignedCoursesByRead = collect($validated['read'])->filter(fn ($read) => boolval($read));
        $assignedCoursesByWrite = collect($validated['write'])->filter(fn ($write) => boolval($write));
        $mergedAssignedCourses = $assignedCoursesByRead->union($assignedCoursesByWrite);

        $user->courses()->syncWithoutDetaching($mergedAssignedCourses->keys());

        if (!empty($validated['read'])) {
            $unAssignedCourses = collect($validated['read'])->filter(fn ($read) => !boolval($read));

            $user->courses()->updateExistingPivot($assignedCoursesByRead->keys(), ['view' => true]);
            $user->courses()->updateExistingPivot($unAssignedCourses->keys(), ['view' => false]);
        }

        if (!empty($validated['write'])) {
            $unAssignedCourses = collect($validated['write'])->filter(fn ($write) => !boolval($write));

            $user->courses()->updateExistingPivot($assignedCoursesByWrite->keys(), ['participate' => true]);
            $user->courses()->updateExistingPivot($unAssignedCourses->keys(), ['participate' => false]);
        }

        return redirect()->back()->with([
            'status' => 'success',
            'message' => 'Instructor was successfully updated',
            'updatedSubject' => $user->id
        ]);
    }

    public function updateCourseAssignment(Request $request, $id)
    {
        $user = User::withinAuthGeneralPrograms()->instructors()->findOrFail($id);

        $validated = $request->validate([
            'write' => 'nullable|array',
            'read' => 'nullable|array'
        ]);

        $assignedCoursesByRead = collect($validated['read'])->filter(fn ($read) => boolval($read));
        $assignedCoursesByWrite = collect($validated['write'])->filter(fn ($write) => boolval($write));
        $mergedAssignedCourses = $assignedCoursesByRead->union($assignedCoursesByWrite);

        $user->courses()->syncWithoutDetaching($mergedAssignedCourses->keys());

        if (!empty($validated['read'])) {
            $unAssignedCourses = collect($validated['read'])->filter(fn ($read) => !boolval($read));

            $user->courses()->updateExistingPivot($assignedCoursesByRead->keys(), ['view' => true]);
            $user->courses()->updateExistingPivot($unAssignedCourses->keys(), ['view' => false]);
        }

        if (!empty($validated['write'])) {
            $unAssignedCourses = collect($validated['write'])->filter(fn ($write) => !boolval($write));

            $user->courses()->updateExistingPivot($assignedCoursesByWrite->keys(), ['participate' => true]);
            $user->courses()->updateExistingPivot($unAssignedCourses->keys(), ['participate' => false]);
        }

        return redirect()->back()->with([
            'status' => 'success',
            'message' => 'Instructor was successfully updated',
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
        $instructor = User::withTrashed()->withinAuthPrograms()->instructors()->findOrFail($id);

        if ($instructor->trashed()) {
            $instructor->restore();
            $message = 'Instructor was successfully restored';
        } else {
            $instructor->delete();
            $message = 'Instructor was successfully trashed';
        }

        return redirect()->back()->with([
            'status' => 'success',
            'message' => $message,
            'updatedSubject' => $instructor->id
        ]);
    }
}
