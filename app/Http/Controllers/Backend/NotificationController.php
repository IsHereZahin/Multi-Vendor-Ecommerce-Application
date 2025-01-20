<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    // Mark a single notification as read
    public function markAsRead($id)
    {
        $userUnreadNotification = auth()->user()
            ->unreadNotifications
            ->where('id', $id)
            ->first();

        if ($userUnreadNotification) {
            $userUnreadNotification->markAsRead();
        }

        return back();
    }

    // Mark all unread notifications as read
    public function markAllAsRead()
    {
        $user = Auth::user();

        // Loop through unread notifications and mark each as read
        $user->unreadNotifications->each(function ($notification) {
            $notification->markAsRead();
        });

        $notification = array(
            'alert-type' => 'info',
            'message'   => 'All notifications marked as read!'
        );

        return back()->with($notification);
    }
}
