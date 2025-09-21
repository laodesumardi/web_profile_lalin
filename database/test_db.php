<?php

require __DIR__.'/../vendor/autoload.php';

$app = require_once __DIR__.'/../bootstrap/app.php';

$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

header('Content-Type: text/plain');
echo "=== Database Connection Test ===\n";

try {
    // Test database connection
    DB::connection()->getPdo();
    echo "✅ Database connection successful\n";
    
    // Check if users table exists
    if (Schema::hasTable('users')) {
        echo "✅ Users table exists\n";
        
        // Get users table columns
        $columns = Schema::getColumnListing('users');
        echo "Users table columns: " . implode(', ', $columns) . "\n";
    } else {
        echo "❌ Users table does not exist\n";
    }
    
    // Check if profiles table exists
    if (Schema::hasTable('profiles')) {
        echo "✅ Profiles table exists\n";
        
        // Get profiles table columns
        $columns = Schema::getColumnListing('profiles');
        echo "Profiles table columns: " . implode(', ', $columns) . "\n";
        
        // Check for photo column
        if (in_array('photo', $columns)) {
            echo "✅ Photo column exists in profiles table\n";
        } else {
            echo "❌ Photo column is missing from profiles table\n";
        }
    } else {
        echo "❌ Profiles table does not exist\n";
    }
    
    // Check for foreign key constraint
    try {
        $constraints = DB::select("
            SELECT * FROM information_schema.TABLE_CONSTRAINTS 
            WHERE CONSTRAINT_TYPE = 'FOREIGN KEY' 
            AND TABLE_NAME = 'profiles'
            AND CONSTRAINT_NAME = 'profiles_user_id_foreign'
        ");
        
        if (!empty($constraints)) {
            echo "✅ Foreign key constraint exists\n";
        } else {
            echo "❌ Foreign key constraint is missing\n";
        }
    } catch (\Exception $e) {
        echo "❌ Error checking foreign key constraint: " . $e->getMessage() . "\n";
    }
    
} catch (\Exception $e) {
    echo "❌ Database connection failed: " . $e->getMessage() . "\n";
}

echo "\n=== Test Complete ===\n";
