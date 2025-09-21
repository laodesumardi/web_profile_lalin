<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\News;

class WelcomeController extends Controller
{
    public function index()
    {
        // Check if is_active column exists
        $connection = config('database.default');
        $driver = config("database.connections.{$connection}.driver");
        $table = 'users';
        $columnExists = false;
        
        if ($driver === 'mysql') {
            $columnExists = \DB::select(
                "SELECT COUNT(*) as count FROM information_schema.columns 
                WHERE table_schema = ? AND table_name = ? AND column_name = 'is_active'",
                [config("database.connections.{$connection}.database"), $table]
            )[0]->count > 0;
        }

        // Get featured employees (users with profiles)
        $query = User::with('profile')
            ->whereHas('profile')
            ->where('role', 'pegawai') // Only get employees
            ->orderBy('name'); // Order by name
            
        // Only filter by is_active if the column exists
        if ($columnExists) {
            $query->where('is_active', true);
        }
            
        $featuredEmployees = $query->take(6)->get();

        // Get latest published news only
        $latestNews = News::with('user.profile')
            ->published()
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();

        return view('welcome', compact('featuredEmployees', 'latestNews'));
    }
}