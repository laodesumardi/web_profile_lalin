<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserDashboardController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\WelcomeController;
use Illuminate\Support\Facades\DB;

// Test route for database connection and table structure
Route::get('/test-db', function () {
    try {
        // Test database connection
        DB::connection()->getPdo();

        // Check if news table exists
        $tables = DB::select('SHOW TABLES');
        $tables = array_map('current', json_decode(json_encode($tables), true));

        $result = [];
        $result[] = 'Connected to database: ' . DB::connection()->getDatabaseName();
        $result[] = 'Tables in database: ' . implode(', ', $tables);

        // Check if news table exists
        if (in_array('news', $tables)) {
            // Get news table columns
            $columns = DB::getSchemaBuilder()->getColumnListing('news');
            $result[] = 'News table columns: ' . implode(', ', $columns);

            // Check if is_published and published_at columns exist
            $hasIsPublished = in_array('is_published', $columns);
            $hasPublishedAt = in_array('published_at', $columns);

            $result[] = 'Has is_published column: ' . ($hasIsPublished ? 'Yes' : 'No');
            $result[] = 'Has published_at column: ' . ($hasPublishedAt ? 'Yes' : 'No');

            // Get some sample data
            $sample = DB::table('news')->first();
            if ($sample) {
                $result[] = 'Sample news item: ' . json_encode([
                    'id' => $sample->id,
                    'title' => $sample->title,
                    'is_published' => $sample->is_published ?? 'null',
                    'published_at' => $sample->published_at ?? 'null'
                ]);
            } else {
                $result[] = 'No news items found in the database.';
            }
        } else {
            $result[] = 'News table does not exist in the database.';
        }

        // Check if users table exists
        if (in_array('users', $tables)) {
            $columns = DB::getSchemaBuilder()->getColumnListing('users');
            $result[] = 'Users table columns: ' . implode(', ', $columns);

            // Get the column type for the role column
            $roleColumnType = DB::getSchemaBuilder()->getColumnType('users', 'role');
            $result[] = 'Role column type: ' . $roleColumnType;

            // Get sample user data
            $sampleUser = DB::table('users')->first();
            if ($sampleUser) {
                $result[] = 'Sample user: ' . json_encode([
                    'id' => $sampleUser->id,
                    'name' => $sampleUser->name,
                    'email' => $sampleUser->email,
                    'role' => $sampleUser->role ?? 'null',
                    'is_active' => $sampleUser->is_active ?? 'null'
                ]);
            }
        }

        return implode("\n<br>", $result);
    } catch (\Exception $e) {
        return 'Error: ' . $e->getMessage() . "\n<br>" .
            'File: ' . $e->getFile() . ':' . $e->getLine();
    }
});

// Public routes
Route::get('/', [WelcomeController::class, 'index'])->name('home');

Route::get('/news', [NewsController::class, 'index'])->name('news.index');
// Handle both ID and slug for news articles
Route::get('/news/{news}', [NewsController::class, 'show'])->name('news.show');
Route::get('/employees', [EmployeeController::class, 'index'])->name('employees.index');
Route::get('/employees/{id}', [EmployeeController::class, 'show'])->name('employees.show');

// Authentication routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Protected routes
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');

    // Password Change Routes
    Route::get('/password/change', [ProfileController::class, 'showChangePasswordForm'])->name('password.change');
    Route::post('/password/change', [ProfileController::class, 'changePassword'])->name('password.update');

    // News routes for authenticated users
    Route::get('news/create', [NewsController::class, 'create'])->name('news.create');
    Route::post('news', [NewsController::class, 'store'])->name('news.store');

    // User's own news management
    Route::prefix('my-news')->name('my.')->group(function () {
        Route::get('/', [NewsController::class, 'myNews'])->name('news.index');
        Route::get('/{news}/edit', [NewsController::class, 'edit'])->name('news.edit');
        Route::put('/{news}', [NewsController::class, 'update'])->name('news.update');
    });

    // Admin routes
    Route::middleware('admin')->prefix('admin')->group(function () {
        // Dashboard
        Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');

        // News Management
        Route::prefix('news')->group(function () {
            Route::get('/', [NewsController::class, 'index'])->name('admin.news.index');
            Route::get('/create', [NewsController::class, 'create'])->name('admin.news.create');
            Route::post('/', [NewsController::class, 'store'])->name('admin.news.store');
            Route::get('/{id}/edit', [NewsController::class, 'edit'])->name('admin.news.edit');
            Route::put('/{id}', [NewsController::class, 'update'])->name('admin.news.update');
            Route::patch('/{id}/toggle-publish', [NewsController::class, 'togglePublish'])->name('admin.news.toggle-publish');
            Route::delete('/{id}', [NewsController::class, 'destroy'])->name('admin.news.destroy');
        })->where('id', '[0-9]+');

        // Employee Management
        Route::prefix('employees')->group(function () {
            Route::get('/', [EmployeeController::class, 'adminIndex'])->name('admin.employees.index');
            Route::get('/create', [EmployeeController::class, 'create'])->name('admin.employees.create');
            Route::post('/', [EmployeeController::class, 'store'])->name('admin.employees.store');
            Route::get('/{employee}/edit', [EmployeeController::class, 'edit'])->name('admin.employees.edit');
            Route::put('/{employee}', [EmployeeController::class, 'update'])->name('admin.employees.update');
            Route::delete('/{employee}', [EmployeeController::class, 'destroy'])->name('admin.employees.destroy');
        });
    });
});
