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

class UsersController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(User::class);
    }


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
        if (File::exists(storage_path("app/public/users/{$user->id}"))) {
            $fileCount = collect(File::allFiles(storage_path("app/public/users/{$user->id}")))->count();
        }

        return view('pages.user.show', compact('user', 'fileCount'));
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

        if ($user->trashed()) {
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

    public function submissions(UserResourcesDataTable $dataTable, User $user)
    {
        return $dataTable->render('pages.user.submissions', compact('user'));
    }


    public function notifications(UserNotificationsDataTable $dataTable, User $user)
    {
        $notifications = $user->notifications;

        return $dataTable->render('pages.user.notifications', compact('user', 'notifications'));
    }

    public function activities(UserActivitiesDataTable $dataTable, User $user)
    {
        return $dataTable->render('pages.user.activities', compact('user'));
    }

    public function lessons(UserLessonsDataTable $dataTable, User $user)
    {
        return $dataTable->render('pages.user.lessons', compact('user'));
    }

    public function editLesson(User $user, Lesson $lesson)
    {
        return view('pages.user.lessons-edit', compact('lesson', 'user'));
    }
}
