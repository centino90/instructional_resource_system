<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
    public function show(User $user)
    {
        $fileCount = 0;
        if(File::exists(storage_path("app/public/users/{$user->id}"))) {
            $fileCount = collect(File::allFiles(storage_path("app/public/users/{$user->id}")))->count();
        }

        return view('pages.user-show', compact('user', 'fileCount'));
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

    public function updatePersonal(Request $request, User $user)
    {
        $user->fname = $request->fname;
        $user->lname = $request->lname;
        $user->save();

        return redirect()->back()->with([
            'status' => 'success',
            'message' => "User personal information was successfully updated!"
        ]);
    }

    public function updateUsername(Request $request, User $user)
    {
        $user->username = $request->username;
        $user->save();

        return redirect()->back()->with([
            'status' => 'success',
            'message' => "Username was successfully updated!"
        ]);
    }

    public function updatePassword(Request $request, User $user)
    {
        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->back()->with([
            'status' => 'success',
            'message' => "User password was successfully updated!"
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

        if($user->trashed()) {
            $user->restore();
            $message = 'User was successfully restored';
        } else {
            $user->delete();
            $message = 'User was successfully deleted';
        }

        return redirect()->back()->with([
            'status' => 'success',
            'updatedSubject' => $id,
            'message' => $message
        ]);
    }

    public function submissions(User $user)
    {
        $submissions = $user->resources()->withoutArchived()->get();
        $pendingSubmissions = $submissions->whereNull('approved_at');

        $archivedSubmissions = $user->resources()->onlyArchived()->get();
        $trashedSubmissions = $user->resources()->onlyTrashed()->get();

        return view('pages.user-submissions', compact('user', 'submissions', 'pendingSubmissions', 'archivedSubmissions', 'trashedSubmissions'));
    }


    public function notifications(User $user)
    {
        $notifications = $user->notifications;

        return view('pages.user-notifications', compact('user', 'notifications'));
    }

    public function activities(User $user)
    {
        $userLogs = $user->activityLogs;

        return view('pages.user-activities', compact('user', 'userLogs'));
    }

    public function lessons(User $user)
    {
        // $lessons = Lesson::whereHas('course', function(Builder $query) use($user) {
        //     return $query->whereIn('program_id', $user->programs->pluck('id'));
        // })->get();
        $lessons = $user->lessons()->withoutArchived()->latest()->get();
        $archivedLessons = $user->lessons()->onlyArchived()->latest('archived_at')->get();
        $trashedLessons = $user->lessons()->onlyTrashed()->latest('deleted_at')->get();

        return view('pages.user-lessons', compact('user', 'lessons', 'archivedLessons', 'trashedLessons'));
    }
}
