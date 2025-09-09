<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Website;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        $stats = [
            'total_users' => User::count(),
            'total_websites' => Website::count(),
            'active_websites' => Website::where('is_published', true)->count(),
            'users_this_month' => User::whereMonth('created_at', now()->month)->count(),
            'websites_this_month' => Website::whereMonth('created_at', now()->month)->count(),
        ];
        
        return view('admin.reports.index', compact('stats'));
    }
}
