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
        $userId = auth()->id();

        // Friend requests (pending only)
        $friendRequests = Friendship::where('receiver_id', $userId)
            ->where('status', 'pending')
            ->with('sender') // assuming you have sender() relationship in Friendship model
            ->latest()
            ->get();

        // Post/comment notifications
        $notifications = Notification::where('user_id', $userId)
            ->latest()
            ->get();

        // Mark comment notifications as read
        Notification::where('user_id', $userId)->update(['is_read' => true]);

        return view('notifications.index', compact('notifications', 'friendRequests'));
    }

}
