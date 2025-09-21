<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

try {
    // Test database connection
    DB::connection()->getPdo();
    echo "<h1>Database Connection Test</h1>";
    echo "<p>Connected to database: " . DB::connection()->getDatabaseName() . "</p>";
    
    // Get all tables
    $tables = DB::select('SHOW TABLES');
    $tableNames = [];
    $key = 'Tables_in_' . DB::connection()->getDatabaseName();
    
    foreach ($tables as $table) {
        $tableNames[] = $table->$key;
    }
    
    echo "<h2>Tables in database:</h2>";
    echo "<ul>";
    foreach ($tableNames as $table) {
        echo "<li>$table</li>";
    }
    echo "</ul>";
    
    // Check users table
    if (in_array('users', $tableNames)) {
        echo "<h2>Users Table Structure:</h2>";
        $columns = DB::select('SHOW COLUMNS FROM users');
        echo "<table border='1' cellpadding='5' cellspacing='0'>";
        echo "<tr><th>Field</th><th>Type</th><th>Null</th><th>Key</th><th>Default</th><th>Extra</th></tr>";
        foreach ($columns as $column) {
            echo "<tr>";
            echo "<td>" . $column->Field . "</td>";
            echo "<td>" . $column->Type . "</td>";
            echo "<td>" . $column->Null . "</td>";
            echo "<td>" . $column->Key . "</td>";
            echo "<td>" . ($column->Default ?? 'NULL') . "</td>";
            echo "<td>" . $column->Extra . "</td>";
            echo "</tr>";
        }
        echo "</table>";
        
        // Show sample user data
        $users = DB::table('users')->limit(5)->get();
        if ($users->count() > 0) {
            echo "<h2>Sample User Data:</h2>";
            echo "<table border='1' cellpadding='5' cellspacing='0'>";
            // Get column headers
            echo "<tr>";
            foreach (array_keys((array)$users->first()) as $column) {
                echo "<th>$column</th>";
            }
            echo "</tr>";
            
            // Get data rows
            foreach ($users as $user) {
                echo "<tr>";
                foreach ((array)$user as $value) {
                    echo "<td>" . (is_null($value) ? 'NULL' : $value) . "</td>";
                }
                echo "</tr>";
            }
            echo "</table>";
        }
    }
    
} catch (\Exception $e) {
    echo "<h1>Error</h1>";
    echo "<p>" . $e->getMessage() . "</p>";
    echo "<p>File: " . $e->getFile() . " (Line: " . $e->getLine() . ")</p>";
    echo "<h2>Stack Trace:</h2>";
    echo "<pre>" . $e->getTraceAsString() . "</pre>";
}
