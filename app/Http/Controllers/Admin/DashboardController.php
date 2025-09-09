<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Website;
use App\Models\Plan;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_users' => User::count(),
            'total_websites' => Website::count(),
            'active_websites' => Website::where('is_published', true)->count(),
            'total_plans' => Plan::count(),
        ];

        $recent_users = User::latest()->take(5)->get();
        $recent_websites = Website::with('user')->latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'recent_users', 'recent_websites'));
    }
}
