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
    public function index(Request $request)
    {
        $startDate = $request->input('start_date', now()->subDays(30)->format('Y-m-d'));
        $endDate = $request->input('end_date', now()->format('Y-m-d'));

        $stats = [
            'total_posts' => Post::count(),
            'published_posts' => Post::published()->count(),
            'pending_posts' => Post::pending()->count(),
            'total_users' => User::count(),
            'total_categories' => Category::count(),
            'total_comments' => Comment::count(),
        ];

        // Thống kê theo khoảng thời gian
        $dateStats = [
            'posts_in_period' => Post::whereBetween('created_at', [$startDate, $endDate])->count(),
            'comments_in_period' => Comment::whereBetween('created_at', [$startDate, $endDate])->count(),
            'users_in_period' => User::whereBetween('created_at', [$startDate, $endDate])->count(),
        ];

        $recent_posts = Post::with(['user', 'category'])
            ->latest()
            ->take(5)
            ->get();

        $recent_comments = Comment::with(['user', 'post'])
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'dateStats', 'recent_posts', 'recent_comments', 'startDate', 'endDate'));
    }
}
