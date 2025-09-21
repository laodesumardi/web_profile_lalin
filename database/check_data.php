<?php

// Database configuration
$host = '127.0.0.1';
$dbname = 'laravel';
$username = 'root';
$password = '';

try {
    // Create connection
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "✅ Successfully connected to the database\n\n";
    
    // List all tables
    echo "=== DATABASE TABLES ===\n";
    $tables = $conn->query("SHOW TABLES")->fetchAll(PDO::FETCH_COLUMN);
    
    if (empty($tables)) {
        echo "No tables found in the database.\n";
    } else {
        foreach ($tables as $table) {
            echo "- $table\n";
        }
    }
    
    // Check users table
    echo "\n=== USERS TABLE ===\n";
    try {
        $stmt = $conn->query("SELECT COUNT(*) as count FROM users");
        $count = $stmt->fetch(PDO::FETCH_ASSOC)['count'];
        echo "Number of users: $count\n";
        
        if ($count > 0) {
            $users = $conn->query("SELECT id, name, email, role, created_at FROM users")->fetchAll(PDO::FETCH_ASSOC);
            foreach ($users as $user) {
                echo "- ID: {$user['id']}, Name: {$user['name']}, Email: {$user['email']}, Role: {$user['role']}, Created: {$user['created_at']}\n";
            }
        }
    } catch (PDOException $e) {
        echo "❌ Error checking users table: " . $e->getMessage() . "\n";
    }
    
    // Check profiles table
    echo "\n=== PROFILES TABLE ===\n";
    try {
        $stmt = $conn->query("SELECT COUNT(*) as count FROM profiles");
        $count = $stmt->fetch(PDO::FETCH_ASSOC)['count'];
        echo "Number of profiles: $count\n";
        
        if ($count > 0) {
            $profiles = $conn->query("SELECT p.*, u.email FROM profiles p JOIN users u ON p.user_id = u.id")->fetchAll(PDO::FETCH_ASSOC);
            foreach ($profiles as $profile) {
                echo "- ID: {$profile['id']}, User ID: {$profile['user_id']}, Email: {$profile['email']}, Photo: {$profile['photo']}\n";
            }
        }
    } catch (PDOException $e) {
        echo "❌ Error checking profiles table: " . $e->getMessage() . "\n";
    }
    
} catch(PDOException $e) {
    die("❌ Connection failed: " . $e->getMessage() . "\n");
}

echo "\n=== Check Complete ===\n";
