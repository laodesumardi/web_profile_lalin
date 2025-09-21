<?php

require __DIR__.'/../vendor/autoload.php';

$app = require_once __DIR__.'/../bootstrap/app.php';

$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

header('Content-Type: text/plain');

echo "=== Starting Database Setup ===\n\n";

try {
    // Create database if it doesn't exist
    $databaseName = config('database.connections.mysql.database');
    $charset = config('database.connections.mysql.charset', 'utf8mb4');
    $collation = config('database.connections.mysql.collation', 'utf8mb4_unicode_ci');
    
    echo "Creating database '$databaseName' if it doesn't exist...\n";
    
    DB::statement("CREATE DATABASE IF NOT EXISTS `$databaseName` CHARACTER SET $charset COLLATE $collation");
    
    // Connect to the database
    DB::reconnect();
    
    echo "✅ Database ready\n\n";
    
    // Run migrations
    echo "Running migrations...\n";
    
    $migrateCommand = 'migrate:fresh --force';
    $migrateExitCode = \Artisan::call($migrateCommand);
    
    if ($migrateExitCode === 0) {
        echo "✅ Migrations completed successfully\n\n";
        
        // Run seeders
        echo "Running seeders...\n";
        
        $seedExitCode = \Artisan::call('db:seed', ['--force' => true]);
        
        if ($seedExitCode === 0) {
            echo "✅ Seeders completed successfully\n\n";
            
            // Verify data
            echo "Verifying data...\n";
            
            $users = DB::table('users')->count();
            $profiles = DB::table('profiles')->count();
            
            echo "- Users: $users\n";
            echo "- Profiles: $profiles\n";
            
            if ($users > 0 && $profiles > 0) {
                echo "\n✅ Setup completed successfully!\n";
                echo "You can now access the application at: http://127.0.0.1:8000\n";
            } else {
                echo "\n❌ Setup completed but no users or profiles were created.\n";
            }
            
        } else {
            echo "❌ Error running seeders. Exit code: $seedExitCode\n";
        }
        
    } else {
        echo "❌ Error running migrations. Exit code: $migrateExitCode\n";
    }
    
} catch (\Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . ":" . $e->getLine() . "\n";
}

echo "\n=== Setup Complete ===\n";
