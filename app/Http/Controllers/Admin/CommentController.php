<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function index(Request $request)
    {
        $query = Comment::with(['user', 'post']);

        if ($request->has('post_id')) {
            $query->where('post_id', $request->post_id);
        }

        if ($request->has('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        $comments = $query->latest()->paginate(20);

        return view('admin.comments.index', compact('comments'));
    }

    public function destroy(Comment $comment)
    {
        $comment->delete();

        return redirect()->back()->with('success', 'Bình luận đã được xóa.');
    }

    public function toggleVisibility(Comment $comment)
    {
        $comment->update(['is_visible' => !$comment->is_visible]);

        $status = $comment->is_visible ? 'hiện' : 'ẩn';

        return redirect()->back()->with('success', "Bình luận đã được {$status}.");
    }
}
