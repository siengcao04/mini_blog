<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Post::with(['user', 'category', 'tags'])
            ->published()
            ->latest('published_at');

        // Tìm kiếm
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%");
            });
        }

        // Lọc theo category
        if ($request->has('category')) {
            $query->whereHas('category', function($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        // Lọc theo tag
        if ($request->has('tag')) {
            $query->whereHas('tags', function($q) use ($request) {
                $q->where('slug', $request->tag);
            });
        }

        $posts = $query->paginate(10);
        $categories = Category::all();
        $tags = Tag::all();

        // Lấy tin nổi bật
        $featuredPosts = Post::featured()
            ->published()
            ->latest('published_at')
            ->limit(3)
            ->get();

        return view('posts.index', compact('posts', 'categories', 'tags', 'featuredPosts'));
    }

    /**
     * Display the specified resource.
     */
    public function show($slug)
    {
        $post = Post::with(['user', 'category', 'tags', 'comments.user'])
            ->where('slug', $slug)
            ->published()
            ->firstOrFail();

        // Tăng lượt xem
        $post->incrementViews();

        // Lấy bài viết liên quan (cùng danh mục, khác bài hiện tại)
        $relatedPosts = Post::where('category_id', $post->category_id)
            ->where('id', '!=', $post->id)
            ->published()
            ->latest('published_at')
            ->limit(5)
            ->get();

        // Lấy bài viết hot (nhiều lượt xem nhất)
        $hotPosts = Post::published()
            ->orderBy('views', 'desc')
            ->limit(5)
            ->get();

        return view('posts.show', compact('post', 'relatedPosts', 'hotPosts'));
    }
}
