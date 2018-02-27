<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserNotificationController extends Controller
{
    public function index() 
    {
       return auth()->user()->unreadNotifications;
    }

    public function destroy($notificationId) 
    {
        $notification = auth()->user()->unreadNotifications()->findOrFail($notificationId);
        $notification->markAsRead();
        return redirect($notification->data['link']);
    }
}
