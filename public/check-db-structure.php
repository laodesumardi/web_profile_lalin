<?php

require __DIR__.'/../vendor/autoload.php';

$app = require_once __DIR__.'/../bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

header('Content-Type: text/plain');

echo "=== Database Structure Check ===\n\n";

// Check users table
if (Schema::hasTable('users')) {
    echo "✅ Users table exists\n";
    
    // Check columns
    $columns = [
        'id', 'name', 'email', 'email_verified_at', 'password', 'remember_token',
        'created_at', 'updated_at', 'nip', 'position', 'photo', 'role', 'is_active'
    ];
    
    $tableColumns = Schema::getColumnListing('users');
    
    echo "Columns in users table: " . implode(', ', $tableColumns) . "\n\n";
    
    // Check for missing columns
    $missingColumns = array_diff($columns, $tableColumns);
    if (!empty($missingColumns)) {
        echo "❌ Missing columns in users table: " . implode(', ', $missingColumns) . "\n";
    } else {
        echo "✅ All required columns exist in users table\n";
    }
    
    // Check if role column has correct values
    $roles = DB::table('users')->select('role')->distinct()->pluck('role')->toArray();
    echo "Existing roles in users table: " . implode(', ', $roles) . "\n";
    
} else {
    echo "❌ Users table does not exist\n";
}

echo "\n";

// Check profiles table
if (Schema::hasTable('profiles')) {
    echo "✅ Profiles table exists\n";
    
    // Check columns
    $profileColumns = [
        'id', 'user_id', 'bio', 'photo', 'website', 'facebook', 'twitter',
        'instagram', 'linkedin', 'phone', 'address', 'department', 'join_date',
        'created_at', 'updated_at'
    ];
    
    $tableProfileColumns = Schema::getColumnListing('profiles');
    
    echo "Columns in profiles table: " . implode(', ', $tableProfileColumns) . "\n\n";
    
    // Check for missing columns
    $missingProfileColumns = array_diff($profileColumns, $tableProfileColumns);
    if (!empty($missingProfileColumns)) {
        echo "❌ Missing columns in profiles table: " . implode(', ', $missingProfileColumns) . "\n";
    } else {
        echo "✅ All required columns exist in profiles table\n";
    }
    
    // Check foreign key
    $foreignKeys = DB::select("
        SELECT 
            TABLE_NAME, COLUMN_NAME, CONSTRAINT_NAME, REFERENCED_TABLE_NAME, REFERENCED_COLUMN_NAME
        FROM
            INFORMATION_SCHEMA.KEY_COLUMN_USAGE
        WHERE
            REFERENCED_TABLE_SCHEMA = ?
                AND REFERENCED_TABLE_NAME = 'users'
                AND TABLE_NAME = 'profiles'
    ", [config('database.connections.mysql.database')]);
    
    if (empty($foreignKeys)) {
        echo "❌ Foreign key from profiles to users is missing\n";
    } else {
        echo "✅ Foreign key exists from profiles to users\n";
    }
    
} else {
    echo "❌ Profiles table does not exist\n";
}

echo "\n=== Check Complete ===\n";

// Check if there are any employees
$employees = DB::table('users')
    ->where('role', 'pegawai')
    ->where('is_active', true)
    ->count();

echo "Active employees: $employees\n";

// If no employees, suggest running the seeder
if ($employees === 0) {
    echo "\nNo active employees found. You may need to run the database seeder.\n";
    echo "Run: php artisan db:seed --class=TestEmployeesSeeder\n";
}

// Check if the application is in debug mode
echo "\nApp Debug Mode: " . (config('app.debug') ? 'true' : 'false') . "\n";

// Check storage link
echo "Storage link exists: " . (file_exists(public_path('storage')) ? 'Yes' : 'No') . "\n";

// Check if we can write to storage
try {
    $testFile = storage_path('app/test_write.txt');
    file_put_contents($testFile, 'test');
    if (file_exists($testFile)) {
        unlink($testFile);
        echo "Can write to storage: Yes\n";
    } else {
        echo "Can write to storage: No\n";
    }
} catch (Exception $e) {
    echo "Can write to storage: No ({$e->getMessage()})\n";
}
