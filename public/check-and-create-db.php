<?php

// Database configuration
$host = '127.0.0.1';
$username = 'root';
$password = '';
$database = 'laravel';

header('Content-Type: text/plain');

echo "=== Database Check and Create ===\n\n";

try {
    // Connect to MySQL server
    $conn = new PDO("mysql:host=$host", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "✅ Connected to MySQL server\n";
    
    // Check if database exists
    $stmt = $conn->query("SHOW DATABASES LIKE '$database'");
    
    if ($stmt->rowCount() > 0) {
        echo "✅ Database '$database' exists\n";
    } else {
        // Create database
        $conn->exec("CREATE DATABASE `$database` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
        echo "✅ Created database '$database'\n";
    }
    
    // Connect to the database
    $conn->exec("USE `$database`");
    echo "✅ Using database: $database\n";
    
    // Check if users table exists
    $tables = $conn->query("SHOW TABLES LIKE 'users'")->fetchAll();
    
    if (count($tables) > 0) {
        echo "✅ Users table exists\n";
    } else {
        echo "❌ Users table does not exist. You need to run migrations.\n";
    }
    
    // Check if profiles table exists
    $tables = $conn->query("SHOW TABLES LIKE 'profiles'")->fetchAll();
    
    if (count($tables) > 0) {
        echo "✅ Profiles table exists\n";
        
        // Check if there are any profiles
        $profileCount = $conn->query("SELECT COUNT(*) FROM profiles")->fetchColumn();
        echo "Number of profiles: $profileCount\n";
        
        if ($profileCount > 0) {
            // Show first profile with user info
            $profile = $conn->query("
                SELECT p.*, u.name as user_name, u.email, u.role 
                FROM profiles p 
                JOIN users u ON p.user_id = u.id 
                LIMIT 1
            ")->fetch(PDO::FETCH_ASSOC);
            
            echo "\nSample profile with user info:\n";
            print_r($profile);
        }
    } else {
        echo "❌ Profiles table does not exist. You need to run migrations.\n";
    }
    
} catch(PDOException $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    
    // Check if we can connect to MySQL at all
    if (strpos($e->getMessage(), 'Access denied') !== false) {
        echo "\n⚠️  Could not connect to MySQL with the provided credentials.\n";
        echo "Please check your MySQL username and password in the script.\n";
    }
}

echo "\n=== Check Complete ===\n";
