<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Existing stats
        $totalPosts     = Post::count();
        $publishedPosts = Post::where('status', 'published')->count();
        $draftPosts     = Post::where('status', 'draft')->count();
        $myPosts        = Post::where('user_id', $user->id)->count();

        // Chart 1 — Bar: Posts created per month (last 6 months)
        $postsPerMonth = Post::select(
                DB::raw("DATE_FORMAT(created_at, '%b %Y') as month"),
                DB::raw('COUNT(*) as count')
            )
            ->where('created_at', '>=', now()->subMonths(6))
            ->groupBy('month')
            ->orderBy('created_at')
            ->get();

        // Chart 2 — Pie: Posts by status
        $postsByStatus = [
            'Published' => $publishedPosts,
            'Draft'     => $draftPosts,
        ];

        // Chart 3 — Pie: Users by role
        $usersByRole = User::select('role', DB::raw('COUNT(*) as count'))
            ->groupBy('role')
            ->pluck('count', 'role');

        // Chart 4 — Line: Most viewed posts (top 7)
        $mostViewed = Post::orderBy('views', 'desc')
            ->limit(7)
            ->get(['title', 'views']);

        return view('dashboard', compact(
            'totalPosts', 'publishedPosts', 'draftPosts', 'myPosts',
            'postsPerMonth', 'postsByStatus', 'usersByRole', 'mostViewed'
        ));
    }
}