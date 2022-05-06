<?php

namespace App\Http\Controllers;

use App\DataTables\Management\UserActivitiesDataTable as ManagementUserActivitiesDataTable;
use App\DataTables\Management\UserLessonsDataTable as ManagementUserLessonsDataTable;
use App\DataTables\Management\UserNotificationsDataTable as ManagementUserNotificationsDataTable;
use App\DataTables\Management\UserResourcesDataTable as ManagementUserResourcesDataTable;
use App\Models\Lesson;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;

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
        $this->authorize('updateSensitive', $user);

        $validated = $request->validate([
            'fname' => 'required',
            'lname' => 'required',
        ]);

        $user->fname = $validated['fname'];
        $user->lname = $validated['lname'];
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

        $user->username = $validated['username'];
        $user->email = $validated['email'];
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

        $user->password = Hash::make($validated['password']);
        $user->temp_password = null;
        $user->save();

        return redirect()->back()->with([
            'status' => 'success',
            'message' => "User password was successfully updated!"
        ]);
    }

    public function submissions(ManagementUserResourcesDataTable $dataTable, User $user)
    {
        $this->authorize('view', $user);

        return $dataTable->render('pages.user.submissions', compact('user'));
    }

    public function notifications(ManagementUserNotificationsDataTable $dataTable, User $user)
    {
        $this->authorize('viewSensitive', $user);

        $notificationList = $user->notifications->whereNull('read_at');

        return $dataTable->render('pages.user.notifications', compact('user', 'notificationList'));
    }

    public function activities(ManagementUserActivitiesDataTable $dataTable, User $user)
    {
        $this->authorize('view', $user);

        return $dataTable->render('pages.user.activities', compact('user'));
    }

    public function lessons(ManagementUserLessonsDataTable $dataTable, User $user)
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
