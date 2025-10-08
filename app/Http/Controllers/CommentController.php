<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request, $postId)
    {
        $request->validate([
            'content' => 'required|string|max:500',
        ]);

        $comment = Comment::create([
            'post_id' => $postId,
            'user_id' => auth()->id(),
            'content' => $request->content,
        ]);

        $postOwnerId = $comment->post->user_id;
        if ($postOwnerId !== auth()->id()) {
            \App\Models\Notification::create([
                'user_id' => $postOwnerId,
                'from_user_id' => auth()->id(),
                'type' => 'comment',
                'message' => auth()->user()->name . ' commented on your post.',
            ]);
        }


        return back()->with('success', 'Comment added!');
    }

    public function update(Request $request, Comment $comment)
    {
        if ($comment->user_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }

        $request->validate([
            'content' => 'required|string|max:500',
        ]);

        $comment->update([
            'content' => $request->content,
        ]);

        return back()->with('success', 'Comment updated.');
    }

    public function destroy(Comment $comment)
    {
        if ($comment->user_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }

        $comment->delete();

        return back()->with('success', 'Comment deleted.');
    }
}
