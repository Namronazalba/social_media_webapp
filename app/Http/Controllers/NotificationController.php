<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Notification::where('user_id', auth()->id())
            ->latest()
            ->get();

        // Mark all as read
        Notification::where('user_id', auth()->id())
            ->update(['is_read' => true]);

        return view('notifications.index', compact('notifications'));
    }
}
