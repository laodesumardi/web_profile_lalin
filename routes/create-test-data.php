<?php

use App\Models\User;
use App\Models\Category;
use App\Models\News;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

Route::get('/create-test-news-data', function() {
    DB::beginTransaction();
    
    try {
        // Create admin user
        $user = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('password'),
                'role' => 'admin'
            ]
        );

        // Create category
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
                'excerpt' => 'This is a test excerpt',
                'user_id' => $user->id,
                'category_id' => $category->id,
                'is_published' => true,
                'published_at' => now(),
                'created_at' => now(),
                'updated_at' => now()
            ]
        );

        DB::commit();

        return [
            'success' => true,
            'message' => 'Test data created successfully!',
            'news' => [
                'id' => $news->id,
                'slug' => $news->slug,
                'url' => url("/news/{$news->id}"),
                'slug_url' => url("/news/{$news->slug}")
            ]
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
