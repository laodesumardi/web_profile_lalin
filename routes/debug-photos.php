<?php

use App\Models\User;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

Route::get('/debug/photos', function() {
    $users = User::all();
    
    $result = [
        'storage_disk' => 'public',
        'storage_path' => storage_path('app/public'),
        'public_path' => public_path('storage'),
        'storage_link_exists' => file_exists(public_path('storage')),
        'users' => []
    ];
    
    foreach ($users as $user) {
        $result['users'][] = [
            'id' => $user->id,
            'name' => $user->name,
            'photo' => $user->photo,
            'photo_url' => $user->profile_photo_url,
            'photo_exists' => $user->photo ? Storage::disk('public')->exists($user->photo) : false,
            'full_path' => $user->photo ? storage_path('app/public/' . $user->photo) : null
        ];
    }
    
    return $result;
});
