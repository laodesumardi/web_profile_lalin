<?php

use Illuminate\Support\Facades\Route;

Route::get('/test-news-route', function() {
    return response()->json([
        'status' => 'success',
        'message' => 'Test route is working',
        'current_time' => now(),
        'app_env' => config('app.env'),
        'app_debug' => config('app.debug'),
    ]);
});

Route::get('/test-db-connection', function() {
    try {
        DB::connection()->getPdo();
        return 'Database connection successful to: ' . DB::connection()->getDatabaseName();
    } catch (\Exception $e) {
        return 'Database connection failed: ' . $e->getMessage();
    }
});
