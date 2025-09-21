<?php

require __DIR__.'/../vendor/autoload.php';

$app = require_once __DIR__.'/../bootstrap/app.php';

$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

header('Content-Type: text/plain');

try {
    // Read the SQL file
    $sql = file_get_contents(__DIR__.'/fix_profiles_direct.sql');
    
    if ($sql === false) {
        throw new \Exception("Failed to read SQL file");
    }
    
    // Split the SQL file into individual queries
    $queries = explode(';', $sql);
    
    // Execute each query
    foreach ($queries as $query) {
        $query = trim($query);
        if (!empty($query)) {
            echo "Executing: " . substr($query, 0, 100) . (strlen($query) > 100 ? '...' : '') . "\n";
            try {
                DB::statement($query);
                echo "✅ Query executed successfully\n";
            } catch (\Exception $e) {
                echo "❌ Error executing query: " . $e->getMessage() . "\n";
            }
        }
    }
    
    // Verify the table was created
    if (Schema::hasTable('profiles')) {
        echo "\n✅ Profiles table created successfully\n";
        
        // Show the table structure
        $columns = DB::select('DESCRIBE profiles');
        echo "\n=== PROFILES TABLE STRUCTURE ===\n";
        foreach ($columns as $column) {
            echo str_pad($column->Field, 15) . " | " . 
                 str_pad($column->Type, 30) . " | " . 
                 str_pad($column->Null, 5) . " | " . 
                 $column->Key . "\n";
        }
    } else {
        echo "\n❌ Failed to create profiles table\n";
    }
    
} catch (\Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    if ($e->getPrevious()) {
        echo "Previous error: " . $e->getPrevious()->getMessage() . "\n";
    }
}

echo "\n=== Script Complete ===\n";
