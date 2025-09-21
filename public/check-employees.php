<?php

require __DIR__.'/../vendor/autoload.php';

$app = require_once __DIR__.'/../bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

header('Content-Type: text/plain');

echo "=== Employee Data Check ===\n\n";

try {
    // Check users table
    echo "=== Users Table ===\n";
    $users = DB::table('users')->get();
    
    if ($users->isEmpty()) {
        echo "No users found in the database.\n";
    } else {
        echo "Total users: " . $users->count() . "\n";
        
        // Count employees (role = 'pegawai')
        $employees = $users->filter(function($user) {
            return $user->role === 'pegawai';
        });
        
        echo "Employees (role=pegawai): " . $employees->count() . "\n\n";
        
        // Display sample employee data
        echo "Sample employees:\n";
        foreach ($employees->take(5) as $user) {
            echo "- ID: {$user->id}, Name: {$user->name}, Email: {$user->email}, Role: {$user->role}, is_active: " . ($user->is_active ?? 'N/A') . "\n";
        }
    }
    
    // Check profiles table
    echo "\n=== Profiles Table ===\n";
    $profiles = DB::table('profiles')->get();
    
    if ($profiles->isEmpty()) {
        echo "No profiles found in the database.\n";
    } else {
        echo "Total profiles: " . $profiles->count() . "\n";
        
        // Display sample profile data
        echo "Sample profiles with user data:\n";
        $sampleProfiles = DB::table('profiles')
            ->join('users', 'profiles.user_id', '=', 'users.id')
            ->select('profiles.*', 'users.name as user_name', 'users.email', 'users.role')
            ->where('users.role', 'pegawai')
            ->limit(5)
            ->get();
            
        if ($sampleProfiles->isEmpty()) {
            echo "No employee profiles found.\n";
        } else {
            foreach ($sampleProfiles as $profile) {
                echo "- User: {$profile->user_name} ({$profile->email}), Role: {$profile->role}\n";
                echo "  Position: " . ($profile->position ?? 'Not set') . "\n";
                echo "  Department: " . ($profile->department ?? 'Not set') . "\n";
                echo "  Photo: " . ($profile->photo ? 'Exists' : 'Not set') . "\n";
            }
        }
    }
    
    // Check the welcome controller query
    echo "\n=== Welcome Controller Query ===\n";
    
    $featuredEmployees = DB::table('users')
        ->join('profiles', 'users.id', '=', 'profiles.user_id')
        ->where('users.role', 'pegawai')
        ->where('users.is_active', true)
        ->select('users.*', 'profiles.position', 'profiles.photo')
        ->orderBy('users.name')
        ->limit(6)
        ->get();
        
    echo "Number of featured employees found: " . $featuredEmployees->count() . "\n";
    
    if ($featuredEmployees->isNotEmpty()) {
        echo "Sample featured employees:\n";
        foreach ($featuredEmployees as $emp) {
            echo "- {$emp->name} ({$emp->position})\n";
        }
    }
    
} catch (\Exception $e) {
    echo "\n❌ Error: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . ":" . $e->getLine() . "\n";
}

echo "\n=== Check Complete ===\n";
