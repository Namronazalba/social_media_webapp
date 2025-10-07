<?php
namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Friendship;

class PostController extends Controller
{
public function index()
{
    $userId = auth()->id();

    // Get all accepted friendships where user is either sender or receiver
    $friendIds = Friendship::where(function ($q) use ($userId) {
            $q->where('sender_id', $userId)
              ->orWhere('receiver_id', $userId);
        })
        ->where('status', 'accepted')
        ->get()
        ->map(function ($friendship) use ($userId) {
            return $friendship->sender_id == $userId
                ? $friendship->receiver_id
                : $friendship->sender_id;
        })
        ->toArray();

    // Combine user’s ID + friend IDs
    $visibleIds = array_merge([$userId], $friendIds);

    // Fetch posts from user and friends, newest first
    $posts = Post::whereIn('user_id', $visibleIds)
                ->with('user')
                ->latest()
                ->get();

    return view('dashboard', compact('posts'));
}

    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required|string|max:5000',
        ]);

        Post::create([
            'user_id' => Auth::id(),
            'content' => $request->content,
        ]);

        return redirect()->route('dashboard')->with('success', 'Post created!');
    }

    public function edit(Post $post)
    {
        $this->authorize('update', $post); // ensures only the owner can edit

        return view('posts.edit', compact('post'));
    }

    public function update(Request $request, Post $post)
    {
        $this->authorize('update', $post);

        $request->validate(['content' => 'required|string|max:5000']);

        $post->update(['content' => $request->content]);

        return redirect()->route('dashboard')->with('success', 'Post updated!');
    }

    public function destroy(Post $post)
    {
        $this->authorize('delete', $post);

        $post->delete();

        return redirect()->route('dashboard')->with('success', 'Post deleted!');
    }

}
