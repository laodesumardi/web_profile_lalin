<?php

use App\Models\News;
use App\Models\User;
use Illuminate\Support\Facades\DB;

Route::get('/create-test-news', function() {
    try {
        // Create a test user if none exists
        $user = User::first();
        if (!$user) {
            $user = User::create([
                'name' => 'Test User',
                'email' => 'test@example.com',
                'password' => bcrypt('password'),
                'role' => 'admin'
            ]);
        }

        // Create a test news article
        $news = News::create([
            'title' => 'Test News Article',
            'slug' => 'test-news-article',
            'content' => 'This is a test news article content.',
            'excerpt' => 'Test excerpt',
            'user_id' => $user->id,
            'category_id' => 1, // Make sure category with ID 1 exists
            'is_published' => true,
            'published_at' => now()
        ]);

        return [
            'success' => true,
            'message' => 'Test news article created successfully',
            'news_id' => $news->id,
            'news_slug' => $news->slug,
            'view_url' => url("/news/{$news->id}")
        ];

    } catch (\Exception $e) {
        return [
            'success' => false,
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ];
    }
});
