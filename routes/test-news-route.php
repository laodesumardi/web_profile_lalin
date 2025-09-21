<?php

use App\Models\News;
use Illuminate\Support\Facades\Route;

Route::get('/test/news/{id}', function($id) {
    try {
        $news = News::findOrFail($id);
        return response()->json([
            'success' => true,
            'news' => $news->toArray()
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ], 500);
    }
});
