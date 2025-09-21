<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

Route::get('/db-test', function () {
    try {
        DB::connection()->getPdo();
        
        $tables = DB::select('SHOW TABLES');
        
        $result = [
            'connection' => 'Connected to database: ' . DB::connection()->getDatabaseName(),
            'tables' => array_map('current', $tables),
        ];
        
        return response()->json($result);
        
    } catch (\Exception $e) {
        return response()->json([
            'error' => true,
            'message' => $e->getMessage(),
            'config' => [
                'database' => config('database.connections.mysql.database'),
                'username' => config('database.connections.mysql.username'),
                'host' => config('database.connections.mysql.host'),
            ]
        ], 500);
    }
});
