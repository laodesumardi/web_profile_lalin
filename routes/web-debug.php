<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NewsController;

Route::get('/debug-news-create', function() {
    return 'Debug route is working';
})->name('debug.news.create');

Route::get('/news/create', [NewsController::class, 'create'])
    ->name('news.create');
