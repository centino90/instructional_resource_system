<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index(Request $request)
    {
        if ($request->view == 'read-notifications') {
            return view('readnotifications')->with('readNotifications', auth()->user()->notifications()->whereNotNull('read_at')->get());
        }
        return view('notifications');
    }

    public function update($notificationId)
    {
        auth()->user()
            ->unreadNotifications
            ->when($notificationId, function ($query) use ($notificationId) {
                return $query->where('id', $notificationId);
            })
            ->markAsRead();
        return response()->json(['status' => 200, 'message' => 'success']);
    }
}
