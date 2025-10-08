<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\Friendship;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public static function getNotificationCounts()
    {
        $userId = Auth::id();

        $friendRequestCount = Friendship::where('receiver_id', $userId)
            ->where('status', 'pending')
            ->count();

        $unreadNotifications = Notification::where('user_id', $userId)
            ->where('is_read', false)
            ->count();

        return $friendRequestCount + $unreadNotifications;
    }
    public function index()
    {
        $notifications = Notification::where('user_id', auth()->id())
            ->latest()
            ->get();

        Notification::where('user_id', auth()->id())->update(['is_read' => true]);

        return view('notifications.index', compact('notifications'));
    }
}
