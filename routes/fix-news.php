<?php

use App\Models\News;
use App\Models\User;
use App\Models\Category;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

Route::get('/fix-news', function() {
    try {
        DB::beginTransaction();
        
        // Create admin user if not exists
        $user = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('password'),
                'role' => 'admin'
            ]
        );
        
        // Create category if not exists
        $category = Category::firstOrCreate(
            ['slug' => 'general'],
            [
                'name' => 'General',
                'description' => 'General News Category'
            ]
        );
        
        // Create test news article
        $news = News::firstOrCreate(
            ['slug' => 'test-news-article'],
            [
                'title' => 'Test News Article',
                'content' => 'This is a test news article content.',
                'excerpt' => 'Test excerpt for the news article',
                'user_id' => $user->id,
                'category_id' => $category->id,
                'is_published' => true,
                'published_at' => now()
            ]
        );
        
        DB::commit();
        
        return [
            'success' => true,
            'message' => 'Test news article created successfully!',
            'news_url' => url("/news/{$news->id}"),
            'news_slug_url' => url("/news/{$news->slug}")
        ];
        
    } catch (\Exception $e) {
        DB::rollBack();
        return [
            'success' => false,
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ];
    }
});
