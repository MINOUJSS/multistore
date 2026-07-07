<?php

namespace App\Http\Controllers;

class UserNotificationController extends Controller
{
    public function mark_notification_as_read($id)
    {
        $user_notification = \App\Models\UserNotification::find($id);
        $user_notification->is_read = 1;
        $user_notification->read_at = now();
        $user_notification->save();

        return response()->json(['success' => true]);
    }
}
