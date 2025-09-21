<?php

require __DIR__.'/../vendor/autoload.php';

$app = require_once __DIR__.'/../bootstrap/app.php';

$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\DB;

header('Content-Type: text/plain');

try {
    // Test database connection
    DB::connection()->getPdo();
    echo "✅ Database connection successful\n";
    
    // Check if users table exists and show its structure
    $usersTable = DB::select("SHOW TABLES LIKE 'users'");
    if (!empty($usersTable)) {
        echo "\n=== USERS TABLE ===\n";
        $columns = DB::select('DESCRIBE users');
        foreach ($columns as $column) {
            echo "- {$column->Field} | {$column->Type} | {$column->Null} | {$column->Key}\n";
        }
    } else {
        echo "❌ Users table does not exist\n";
    }
    
    // Check if profiles table exists and show its structure
    $profilesTable = DB::select("SHOW TABLES LIKE 'profiles'");
    if (!empty($profilesTable)) {
        echo "\n=== PROFILES TABLE ===\n";
        $columns = DB::select('DESCRIBE profiles');
        foreach ($columns as $column) {
            echo "- {$column->Field} | {$column->Type} | {$column->Null} | {$column->Key}\n";
        }
        
        // Check foreign key constraints
        $foreignKeys = DB::select("
            SELECT * FROM information_schema.TABLE_CONSTRAINTS 
            WHERE CONSTRAINT_TYPE = 'FOREIGN KEY' 
            AND TABLE_NAME = 'profiles'
        ");
        
        echo "\n=== FOREIGN KEYS ===\n";
        if (!empty($foreignKeys)) {
            foreach ($foreignKeys as $fk) {
                echo "- {$fk->CONSTRAINT_NAME}: {$fk->COLUMN_NAME} -> {$fk->REFERENCED_TABLE_NAME}.{$fk->REFERENCED_COLUMN_NAME}\n";
            }
        } else {
            echo "No foreign key constraints found\n";
        }
    } else {
        echo "\n❌ Profiles table does not exist\n";
    }
    
} catch (\Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}

echo "\n=== Check Complete ===\n";
