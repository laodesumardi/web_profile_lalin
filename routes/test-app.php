<?php

use Illuminate\Support\Facades\Route;

Route::get('/test-app', function() {
    return response()->json([
        'app' => 'Laravel Application is running',
        'version' => app()->version(),
        'environment' => app()->environment(),
        'url' => url()->current(),
        'time' => now()->toDateTimeString()
    ]);
});

// Direct test for news route
Route::get('/direct-news-test', function() {
    return response()->json([
        'route' => 'Direct news test',
        'news_route_defined' => \Illuminate\Support\Facades\Route::has('news.show'),
        'all_routes' => collect(\Illuminate\Support\Facades\Route::getRoutes()->getRoutes())
            ->filter(function($route) {
                return str_contains($route->uri, 'news');
            })
            ->map(function($route) {
                return [
                    'uri' => $route->uri,
                    'name' => $route->getName(),
                    'action' => $route->getActionName(),
                    'methods' => $route->methods()
                ];
            })
    ]);
});
