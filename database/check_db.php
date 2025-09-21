<?php

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database configuration
$config = [
    'host' => '127.0.0.1',
    'dbname' => 'laravel',
    'username' => 'root',
    'password' => '',
    'charset' => 'utf8mb4',
];

try {
    // Create connection
    $dsn = "mysql:host={$config['host']};dbname={$config['dbname']};charset={$config['charset']}";
    $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ];
    
    $pdo = new PDO($dsn, $config['username'], $config['password'], $options);
    
    echo "✅ Successfully connected to the database\n\n";
    
    // List all tables
    $tables = $pdo->query("SHOW TABLES")->fetchAll(PDO::FETCH_COLUMN);
    
    echo "=== DATABASE TABLES ===\n";
    if (empty($tables)) {
        echo "No tables found in the database.\n";
    } else {
        foreach ($tables as $table) {
            echo "- $table\n";
        }
    }
    
    // Check users table
    if (in_array('users', $tables)) {
        echo "\n=== USERS TABLE STRUCTURE ===\n";
        $stmt = $pdo->query("DESCRIBE users");
        $columns = $stmt->fetchAll();
        
        foreach ($columns as $column) {
            echo str_pad($column['Field'], 20) . " | " . 
                 str_pad($column['Type'], 30) . " | " . 
                 str_pad($column['Null'], 5) . " | " . 
                 ($column['Key'] ?? '') . "\n";
        }
        
        // Show sample users
        echo "\n=== SAMPLE USERS ===\n";
        $users = $pdo->query("SELECT id, name, email, role, created_at FROM users LIMIT 5")->fetchAll();
        foreach ($users as $user) {
            echo "- ID: {$user['id']}, Name: {$user['name']}, Email: {$user['email']}, Role: {$user['role']}\n";
        }
    }
    
    // Check profiles table
    if (in_array('profiles', $tables)) {
        echo "\n=== PROFILES TABLE STRUCTURE ===\n";
        $stmt = $pdo->query("DESCRIBE profiles");
        $columns = $stmt->fetchAll();
        
        foreach ($columns as $column) {
            echo str_pad($column['Field'], 20) . " | " . 
                 str_pad($column['Type'], 30) . " | " . 
                 str_pad($column['Null'], 5) . " | " . 
                 ($column['Key'] ?? '') . "\n";
        }
        
        // Show sample profiles
        echo "\n=== SAMPLE PROFILES ===\n";
        $profiles = $pdo->query("SELECT p.*, u.email FROM profiles p JOIN users u ON p.user_id = u.id LIMIT 5")->fetchAll();
        foreach ($profiles as $profile) {
            echo "- ID: {$profile['id']}, User ID: {$profile['user_id']}, Email: {$profile['email']}\n";
            echo "  Photo: " . ($profile['photo'] ?? 'NULL') . "\n";
        }
    }
    
    // Check foreign keys
    echo "\n=== FOREIGN KEY CONSTRAINTS ===\n";
    $fks = $pdo->query("
        SELECT 
            TABLE_NAME, COLUMN_NAME, CONSTRAINT_NAME, 
            REFERENCED_TABLE_NAME, REFERENCED_COLUMN_NAME
        FROM 
            INFORMATION_SCHEMA.KEY_COLUMN_USAGE
        WHERE 
            REFERENCED_TABLE_SCHEMA = '{$config['dbname']}'
            AND REFERENCED_TABLE_NAME IS NOT NULL
    ")->fetchAll();
    
    if (empty($fks)) {
        echo "No foreign key constraints found.\n";
    } else {
        foreach ($fks as $fk) {
            echo "- {$fk['TABLE_NAME']}.{$fk['COLUMN_NAME']} -> {$fk['REFERENCED_TABLE_NAME']}.{$fk['REFERENCED_COLUMN_NAME']} (constraint: {$fk['CONSTRAINT_NAME']})\n";
        }
    }
    
} catch (PDOException $e) {
    die("❌ Database error: " . $e->getMessage() . "\n");
} catch (Exception $e) {
    die("❌ Error: " . $e->getMessage() . "\n");
}

echo "\n=== CHECK COMPLETE ===\n";
