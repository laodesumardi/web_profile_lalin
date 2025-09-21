<?php

use App\Models\News;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

Route::get('/test/news/create', function() {
    try {
        // Test database connection
        DB::connection()->getPdo();
        
        // Create test data
        $testData = [
            'title' => 'Test News ' . time(),
            'content' => 'This is a test news content',
            'category_id' => Category::first()?->id ?? 1,
            'user_id' => 1,
            'is_published' => true
        ];
        
        // Try to create news
        $news = News::create($testData);
        
        return [
            'success' => true,
            'news' => $news->toArray(),
            'database' => 'Connected successfully',
            'categories_count' => Category::count(),
            'categories' => Category::all()->toArray(),
            'news_table_columns' => Schema::getColumnListing('news')
        ];
        
    } catch (\Exception $e) {
        return [
            'success' => false,
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString(),
            'database_connection' => [
                'default' => config('database.default'),
                'connection' => config('database.connections.' . config('database.default')),
                'pdo' => DB::connection()->getPdo() ? 'Connected' : 'Not connected'
            ]
        ];
    }
});
