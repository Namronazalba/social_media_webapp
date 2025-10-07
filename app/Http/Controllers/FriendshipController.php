<?php
namespace App\Http\Controllers;

use App\Models\Friendship;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Post;


class FriendshipController extends Controller
{
    public function index()
    {
        $userId = auth()->id();

        // Exclude users that are already friends
        $friends = \App\Models\Friendship::where(function ($q) use ($userId) {
                $q->where('sender_id', $userId)
                ->orWhere('receiver_id', $userId);
            })
            ->where('status', 'accepted')
            ->pluck('sender_id')
            ->merge(
                \App\Models\Friendship::where(function ($q) use ($userId) {
                    $q->where('sender_id', $userId)
                    ->orWhere('receiver_id', $userId);
                })->where('status', 'accepted')->pluck('receiver_id')
            )
            ->unique()
            ->toArray();

        // Pending requests *received* (so you don’t send a duplicate)
        $receivedRequests = \App\Models\Friendship::where('receiver_id', $userId)
            ->where('status', 'pending')
            ->pluck('sender_id')
            ->toArray();

        // Pending requests *sent* (so you can show cancel button)
        $sentRequests = \App\Models\Friendship::where('sender_id', $userId)
            ->where('status', 'pending')
            ->pluck('receiver_id')
            ->toArray();

        // Suggested users:
        // - not yourself
        // - not already friends
        // - not someone who already sent you a request
        $users = \App\Models\User::where('id', '!=', $userId)
            ->whereNotIn('id', $friends)
            ->whereNotIn('id', $receivedRequests)
            ->get();

        return view('friends.index', [
            'users' => $users,
            'pending' => $sentRequests, // for "Request Sent" state
        ]);
    }



    public function addFriend($id)
    {
        $receiver = User::findOrFail($id);

        Friendship::firstOrCreate([
            'sender_id' => auth()->id(),
            'receiver_id' => $receiver->id,
        ]);

        return back()->with('success', 'Friend request sent!');
    }

    public function requests()
    {
        $requests = \App\Models\Friendship::where('receiver_id', auth()->id())
                    ->where('status', 'pending')
                    ->with('sender')
                    ->latest()
                    ->get();

        return view('friends.requests', compact('requests'));
    }

    public function accept($id)
    {
        $friendship = \App\Models\Friendship::findOrFail($id);

        if ($friendship->receiver_id != auth()->id()) {
            abort(403);
        }

        $friendship->update(['status' => 'accepted']);

        return back()->with('success', 'Friend request accepted!');
    }

    public function ignore($id)
    {
        $friendship = \App\Models\Friendship::findOrFail($id);

        if ($friendship->receiver_id != auth()->id()) {
            abort(403);
        }

        $friendship->update(['status' => 'declined']);

        return back()->with('info', 'Friend request ignored.');
    }

    public function cancel($id)
    {
        $friendship = \App\Models\Friendship::where('sender_id', auth()->id())
            ->where('receiver_id', $id)
            ->where('status', 'pending')
            ->firstOrFail();

        $friendship->delete();

        return back()->with('info', 'Friend request cancelled.');
    }


    public function friendsList()
    {
        $userId = auth()->id();

        // Get all accepted friendships where user is either sender or receiver
        $friends = \App\Models\Friendship::where(function ($q) use ($userId) {
                $q->where('sender_id', $userId)
                ->orWhere('receiver_id', $userId);
            })
            ->where('status', 'accepted')
            ->get();

        // Extract friend user models
        $friendUsers = $friends->map(function ($friendship) use ($userId) {
            return $friendship->sender_id == $userId
                ? $friendship->receiver
                : $friendship->sender;
        });

        return view('friends.list', ['friends' => $friendUsers]);
    }

    public function show($id)
    {
        $friend = User::findOrFail($id);

        $isFriend = Friendship::where(function ($q) use ($id) {
                $q->where('sender_id', auth()->id())
                ->where('receiver_id', $id);
            })
            ->orWhere(function ($q) use ($id) {
                $q->where('receiver_id', auth()->id())
                ->where('sender_id', $id);
            })
            ->where('status', 'accepted')
            ->exists();

        $posts = $isFriend || $id === auth()->id()
            ? Post::where('user_id', $id)->latest()->get()
            : collect(); // empty collection if not friend

        return view('friends.profile', compact('friend', 'posts', 'isFriend'));
    }



}

