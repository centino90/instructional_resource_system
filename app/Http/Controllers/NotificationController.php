<?php

namespace App\Http\Controllers;

use App\Notifications\NewResourceNotification;
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
        if (
            auth()->user()
            ->unreadNotifications->where('id', $notificationId)->count() > 0
        ) {
            auth()->user()
                ->unreadNotifications
                ->when($notificationId, function ($query) use ($notificationId) {
                    return $query->where('id', $notificationId);
                })
                ->markAsRead();

            return response()->json(['status' => 200, 'message' => 'success']);
        }

        return response()->json(['status' => 500, 'message' => 'error']);
    }

    public function read($notificationId)
    {
        $notif = auth()->user()
            ->notifications->firstWhere('id', $notificationId);

        if (empty($notif->read_at)) {
            $notif->markAsRead();
        }

        return redirect()->to($notif->data['link']);
    }
}
