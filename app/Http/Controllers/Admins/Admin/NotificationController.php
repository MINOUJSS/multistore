<?php

namespace App\Http\Controllers\Admins\Admin;

use App\Http\Controllers\Controller;

class NotificationController extends Controller
{
    public function index()
    {
        // 
        $notifications = auth('admin')->user()->notifications()->latest()->take(10)->get();
        //maek notifications as read
        $notifications->markAsRead();

        return view('admins.admin.notifications.index', compact('notifications'));
    }
}
