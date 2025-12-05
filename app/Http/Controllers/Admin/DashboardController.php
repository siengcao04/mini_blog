<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\User;
use App\Models\Category;
use App\Models\Comment;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_posts' => Post::count(),
            'published_posts' => Post::published()->count(),
            'pending_posts' => Post::pending()->count(),
            'total_users' => User::count(),
            'total_categories' => Category::count(),
            'total_comments' => Comment::count(),
        ];

        $recent_posts = Post::with(['user', 'category'])
            ->latest()
            ->take(5)
            ->get();

        $recent_comments = Comment::with(['user', 'post'])
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recent_posts', 'recent_comments'));
    }
}
