<?php

use Illuminate\Support\Facades\Route;
use App\Models\Category;

Route::get('/test/news', function() {
    try {
        // Test database connection
        DB::connection()->getPdo();
        
        // Get categories count
        $categories = Category::count();
        
        return [
            'database' => 'Connected successfully',
            'categories_count' => $categories,
            'categories' => Category::all()->toArray()
        ];
    } catch (\Exception $e) {
        return [
            'error' => $e->getMessage(),
            'database_connection' => DB::connection()->getDatabaseName(),
            'env_db' => [
                'db_connection' => config('database.default'),
                'db_database' => config('database.connections.'.config('database.default').'.database')
            ]
        ];
    }
});
