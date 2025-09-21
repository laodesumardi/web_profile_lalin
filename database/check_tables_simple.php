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
    $stmt = $conn->query("SHOW TABLES");
    $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
    
    if (empty($tables)) {
        echo "No tables found in the database.\n";
    } else {
        foreach ($tables as $table) {
            echo "- $table\n";
        }
    }
    
    // Check users table
    echo "\n=== USERS TABLE STRUCTURE ===\n";
    $stmt = $conn->query("DESCRIBE users");
    $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    foreach ($columns as $column) {
        echo str_pad($column['Field'], 20) . " | " . 
             str_pad($column['Type'], 30) . " | " . 
             str_pad($column['Null'], 5) . " | " . 
             ($column['Key'] ?? '') . "\n";
    }
    
    // Check profiles table
    echo "\n=== PROFILES TABLE STRUCTURE ===\n";
    $stmt = $conn->query("DESCRIBE profiles");
    $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    foreach ($columns as $column) {
        echo str_pad($column['Field'], 20) . " | " . 
             str_pad($column['Type'], 30) . " | " . 
             str_pad($column['Null'], 5) . " | " . 
             ($column['Key'] ?? '') . "\n";
    }
    
    // Show some sample data
    echo "\n=== SAMPLE DATA ===\n";
    
    echo "Users:\n";
    $stmt = $conn->query("SELECT id, name, email, role, created_at FROM users LIMIT 5");
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    if (empty($users)) {
        echo "No users found.\n";
    } else {
        foreach ($users as $user) {
            echo "- ID: {$user['id']}, Name: {$user['name']}, Email: {$user['email']}, Role: {$user['role']}, Created: {$user['created_at']}\n";
        }
    }
    
    echo "\nProfiles:\n";
    $stmt = $conn->query("SELECT p.*, u.email FROM profiles p JOIN users u ON p.user_id = u.id LIMIT 5");
    $profiles = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    if (empty($profiles)) {
        echo "No profiles found.\n";
    } else {
        foreach ($profiles as $profile) {
            echo "- ID: {$profile['id']}, User ID: {$profile['user_id']}, Email: {$profile['email']}, Photo: " . ($profile['photo'] ?? 'NULL') . "\n";
        }
    }
    
} catch(PDOException $e) {
    die("❌ Error: " . $e->getMessage() . "\n");
}

echo "\n=== Check Complete ===\n";
