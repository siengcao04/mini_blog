<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class CommentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'post_id' => 'required|exists:posts,id',
            'content' => 'required|string|min:3|max:1000',
        ], [
            'post_id.required' => 'Bài viết không tồn tại.',
            'post_id.exists' => 'Bài viết không tồn tại.',
            'content.required' => 'Nội dung bình luận không được để trống.',
            'content.min' => 'Nội dung bình luận phải có ít nhất :min ký tự.',
            'content.max' => 'Nội dung bình luận không được vượt quá :max ký tự.',
        ]);

        $comment = Comment::create([
            'post_id' => $validated['post_id'],
            'user_id' => auth()->id(),
            'content' => $validated['content'],
        ]);

        return redirect()->back()->with('success', 'Bình luận của bạn đã được đăng.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Comment $comment)
    {
        $this->authorize('update', $comment);

        $validated = $request->validate([
            'content' => 'required|string|min:3|max:1000',
        ], [
            'content.required' => 'Nội dung bình luận không được để trống.',
            'content.min' => 'Nội dung bình luận phải có ít nhất :min ký tự.',
            'content.max' => 'Nội dung bình luận không được vượt quá :max ký tự.',
        ]);

        $comment->update($validated);

        return redirect()->back()->with('success', 'Bình luận đã được cập nhật.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comment $comment)
    {
        $this->authorize('delete', $comment);

        $comment->delete();

        return redirect()->back()->with('success', 'Bình luận đã được xóa.');
    }
}
