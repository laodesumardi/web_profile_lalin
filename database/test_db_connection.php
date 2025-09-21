<?php

require __DIR__.'/../vendor/autoload.php';

$app = require_once __DIR__.'/../bootstrap/app.php';

$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;

header('Content-Type: text/plain');

try {
    // Test database connection
    DB::connection()->getPdo();
    echo "✅ Successfully connected to the database\n";
    
    // List all tables
    echo "\n=== DATABASE TABLES ===\n";
    $tables = DB::select('SHOW TABLES');
    
    if (empty($tables)) {
        echo "No tables found in the database.\n";
    } else {
        foreach ($tables as $table) {
            $tableName = array_values((array)$table)[0];
            echo "- $tableName\n";
        }
    }
    
    // Check users table
    echo "\n=== USERS TABLE ===\n";
    $users = DB::table('users')->count();
    echo "Number of users: $users\n";
    
    if ($users > 0) {
        $sampleUser = DB::table('users')->first();
        echo "Sample user: " . json_encode($sampleUser, JSON_PRETTY_PRINT) . "\n";
    }
    
    // Check profiles table
    echo "\n=== PROFILES TABLE ===\n";
    $profiles = DB::table('profiles')->count();
    echo "Number of profiles: $profiles\n";
    
    if ($profiles > 0) {
        $sampleProfile = DB::table('profiles')->first();
        echo "Sample profile: " . json_encode($sampleProfile, JSON_PRETTY_PRINT) . "\n";
    }
    
} catch (\Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . ":" . $e->getLine() . "\n";
}

echo "\n=== Test Complete ===\n";
