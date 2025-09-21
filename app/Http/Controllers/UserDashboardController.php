<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\News;
use App\Models\Profile;

class UserDashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // Middleware is applied at route level
    }

    /**
     * Show the user dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = Auth::user();

        // Get user statistics
        $totalNews = $user->news()->count();
        $monthlyNews = $user->news()->whereMonth('created_at', now()->month)->count();
        $recentNews = $user->news()->latest()->take(5)->get();

        // Get user profile
        $profile = $user->profile;

        return view('dashboard.user', compact('user', 'totalNews', 'monthlyNews', 'recentNews', 'profile'));
    }
}