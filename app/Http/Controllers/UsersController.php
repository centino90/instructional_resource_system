<?php

namespace App\Http\Controllers;

use App\DataTables\User\UserActivitiesDataTable;
use App\DataTables\User\UserLessonsDataTable;
use App\DataTables\User\UserNotificationsDataTable;
use App\DataTables\User\UserResourcesDataTable;
use App\Models\Lesson;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UsersController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        $this->authorize('view', $user);

        $fileCount = 0;
        if (File::exists(storage_path("app/public/users/{$user->id}"))) {
            $fileCount = collect(File::allFiles(storage_path("app/public/users/{$user->id}")))->count();
        }

        return view('pages.user.show', compact('user', 'fileCount'));
    }

    public function updatePersonal(Request $request, User $user)
    {
        $this->authorize('update', $user);

        $validated = $request->validate([
            'fname' => 'required',
            'lname' => 'required',
        ]);

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
        $this->authorize('updateSensitive', $user);

        $validated = $request->validate([
            'username' => 'required|unique:users,username,' . auth()->id(),
            'email' => 'required|unique:users,email,' . auth()->id(),
        ]);

        $user->username = $request->username;
        $user->email = $request->email;
        $user->save();

        return redirect()->back()->with([
            'status' => 'success',
            'message' => "Username was successfully updated!"
        ]);
    }

    public function updatePassword(Request $request, User $user)
    {
        $this->authorize('updateSensitive', $user);

        $validated = $request->validate([
            'password' => 'required|min:6|confirmed',
        ]);

        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->back()->with([
            'status' => 'success',
            'message' => "User password was successfully updated!"
        ]);
    }

    public function submissions(UserResourcesDataTable $dataTable, User $user)
    {
        $this->authorize('view', $user);

        return $dataTable->render('pages.user.submissions', compact('user'));
    }

    public function notifications(UserNotificationsDataTable $dataTable, User $user)
    {
        $this->authorize('viewSensitive', $user);

        $notificationList = $user->notifications->whereNull('read_at');

        return $dataTable->render('pages.user.notifications', compact('user', 'notificationList'));
    }

    public function activities(UserActivitiesDataTable $dataTable, User $user)
    {
        $this->authorize('view', $user);

        return $dataTable->render('pages.user.activities', compact('user'));
    }

    public function lessons(UserLessonsDataTable $dataTable, User $user)
    {
        $this->authorize('view', $user);

        return $dataTable->render('pages.user.lessons', compact('user'));
    }

    public function editLesson(User $user, Lesson $lesson)
    {
        $this->authorize('update', $lesson);

        return view('pages.user.lessons-edit', compact('lesson', 'user'));
    }
}
