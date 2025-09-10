<?php

namespace App\Http\Controllers\Creator;

use App\Http\Controllers\Controller;
use App\Models\Website;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $selectedWebsite = $request->get('selected_website');
        $websites = $user->websites()->latest()->get();
        
        $stats = [
            'total_websites' => $websites->count(),
            'published_websites' => $websites->where('is_published', true)->count(),
            'total_pages' => $websites->sum(function($website) {
                return $website->pages()->count();
            }),
            'total_blog_posts' => $websites->sum(function($website) {
                return $website->blogPosts()->count();
            }),
        ];

        return view('creator.dashboard', compact('websites', 'stats', 'user', 'selectedWebsite'));
    }
}
