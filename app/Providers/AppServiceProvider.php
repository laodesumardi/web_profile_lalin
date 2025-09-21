<?php

namespace App\Providers;

use App\Models\News;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Remove explicit 'news' parameter binding so controller can handle slug/ID resolution safely
        // This avoids premature 404s and redirect loops.
    }
}
