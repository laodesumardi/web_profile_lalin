<?php

require __DIR__.'/../vendor/autoload.php';

$app = require_once __DIR__.'/../bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

header('Content-Type: text/plain');

echo "=== Database Connection Test ===\n\n";

try {
    // Test database connection
    DB::connection()->getPdo();
    echo "✅ Connected to database: " . DB::connection()->getDatabaseName() . "\n\n";
    
    // List all tables
    $tables = DB::select('SHOW TABLES');
    
    if (empty($tables)) {
        echo "ℹ️ No tables found in the database.\n";
    } else {
        echo "📋 Database Tables:\n";
        foreach ($tables as $table) {
            $tableName = array_values((array)$table)[0];
            echo "- $tableName\n";
        }
        echo "\n";
    }
    
    // Check if users table exists
    if (Schema::hasTable('users')) {
        echo "✅ Users table exists\n";
        
        // Show users table columns
        $columns = Schema::getColumnListing('users');
        echo "📋 Users table columns:\n";
        foreach ($columns as $column) {
            $type = DB::getSchemaBuilder()->getColumnType('users', $column);
            echo "- $column ($type)\n";
        }
        
        // Count users
        $userCount = DB::table('users')->count();
        echo "\n👥 Total users: $userCount\n";
        
        if ($userCount > 0) {
            $users = DB::table('users')->select(['id', 'name', 'email', 'role', 'is_active'])->limit(5)->get();
            echo "\nSample users:\n";
            foreach ($users as $user) {
                echo "- ID: {$user->id}, Name: {$user->name}, Email: {$user->email}, Role: {$user->role}, Active: " . ($user->is_active ? 'Yes' : 'No') . "\n";
            }
        }
    } else {
        echo "❌ Users table does not exist\n";
    }
    
} catch (Exception $e) {
    echo "❌ Database connection failed!\n";
    echo "Error: " . $e->getMessage() . "\n\n";
    
    // Show database configuration (without sensitive data)
    echo "Database Configuration:\n";
    echo "- Host: " . config('database.connections.mysql.host') . "\n";
    echo "- Port: " . config('database.connections.mysql.port') . "\n";
    echo "- Database: " . config('database.connections.mysql.database') . "\n";
    echo "- Username: " . config('database.connections.mysql.username') . "\n";
    
    // Check if database exists
    try {
        $pdo = new PDO(
            "mysql:host=" . config('database.connections.mysql.host') . 
            ";port=" . config('database.connections.mysql.port'),
            config('database.connections.mysql.username'),
            config('database.connections.mysql.password')
        );
        
        $stmt = $pdo->query("SHOW DATABASES LIKE '" . config('database.connections.mysql.database') . "'");
        $dbExists = $stmt->rowCount() > 0;
        
        echo "\nDatabase exists: " . ($dbExists ? '✅ Yes' : '❌ No') . "\n";
        
        if (!$dbExists) {
            echo "\nTo create the database, run this SQL command in your MySQL client:\n";
            echo "CREATE DATABASE `" . config('database.connections.mysql.database') . "` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;\n";
        }
        
    } catch (Exception $e) {
        echo "\n⚠️ Could not check if database exists: " . $e->getMessage() . "\n";
    }
}

echo "\n=== End of Database Test ===\n";

require __DIR__.'/../vendor/autoload.php';

$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Ill\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

try {
    echo "<h1>Database Connection Test</h1>";
    
    // Test database connection
    DB::connection()->getPdo();
    echo "<p>✅ Connected to database: " . DB::connection()->getDatabaseName() . "</p>";
    
    // Check if users table exists
    if (Schema::hasTable('users')) {
        echo "<p>✅ Users table exists</p>";
        
        // Get columns
        $columns = Schema::getColumnListing('users');
        echo "<h3>Users Table Columns:</h3>";
        echo "<ul>";
        foreach ($columns as $column) {
            $type = DB::getSchemaBuilder()->getColumnType('users', $column);
            echo "<li>{$column} ({$type})</li>";
        }
        echo "</ul>";
        
        // Check if required columns exist
        $requiredColumns = ['name', 'email', 'password', 'nip', 'position', 'role', 'is_active'];
        $missingColumns = array_diff($requiredColumns, $columns);
        
        if (empty($missingColumns)) {
            echo "<p>✅ All required columns exist</p>";
        } else {
            echo "<p>❌ Missing columns: " . implode(', ', $missingColumns) . "</p>";
        }
        
        // Show sample user data
        $users = DB::table('users')->limit(3)->get();
        if ($users->count() > 0) {
            echo "<h3>Sample User Data:</h3>";
            echo "<pre>" . json_encode($users, JSON_PRETTY_PRINT) . "</pre>";
        } else {
            echo "<p>No users found in the database.</p>";
        }
    } else {
        echo "<p>❌ Users table does not exist</p>";
    }
    
} catch (\Exception $e) {
    echo "<h1>Error</h1>";
    echo "<p>" . $e->getMessage() . "</p>";
    echo "<p>File: " . $e->getFile() . " (Line: " . $e->getLine() . ")</p>";
    echo "<h3>Stack Trace:</h3>";
    echo "<pre>" . $e->getTraceAsString() . "</pre>";
}

echo "<h2>Environment:</h2>";
echo "<pre>";
echo "DB_CONNECTION: " . env('DB_CONNECTION', 'not set') . "\n";
echo "DB_HOST: " . env('DB_HOST', 'not set') . "\n";
echo "DB_PORT: " . env('DB_PORT', 'not set') . "\n";
echo "DB_DATABASE: " . env('DB_DATABASE', 'not set') . "\n";
echo "DB_USERNAME: " . env('DB_USERNAME', 'not set') . "\n";
echo "</pre>";
