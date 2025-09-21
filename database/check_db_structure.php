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
    
    // Check users table
    echo "=== USERS TABLE ===\n";
    $stmt = $conn->query("SHOW COLUMNS FROM users");
    $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    foreach ($columns as $column) {
        echo str_pad($column['Field'], 20) . " | " . 
             str_pad($column['Type'], 30) . " | " . 
             str_pad($column['Null'], 5) . " | " . 
             ($column['Key'] ?? '') . "\n";
    }
    
    // Check profiles table
    echo "\n=== PROFILES TABLE ===\n";
    try {
        $stmt = $conn->query("SHOW COLUMNS FROM profiles");
        $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        if (empty($columns)) {
            echo "No columns found in profiles table\n";
        } else {
            foreach ($columns as $column) {
                echo str_pad($column['Field'], 20) . " | " . 
                     str_pad($column['Type'], 30) . " | " . 
                     str_pad($column['Null'], 5) . " | " . 
                     ($column['Key'] ?? '') . "\n";
            }
        }
    } catch (PDOException $e) {
        echo "❌ Error checking profiles table: " . $e->getMessage() . "\n";
    }
    
    // Check foreign keys
    echo "\n=== FOREIGN KEYS ===\n";
    try {
        $stmt = $conn->query("
            SELECT 
                TABLE_NAME, COLUMN_NAME, CONSTRAINT_NAME, 
                REFERENCED_TABLE_NAME, REFERENCED_COLUMN_NAME
            FROM 
                INFORMATION_SCHEMA.KEY_COLUMN_USAGE
            WHERE 
                REFERENCED_TABLE_SCHEMA = '$dbname' AND
                REFERENCED_TABLE_NAME IS NOT NULL
        ");
        
        $fks = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        if (empty($fks)) {
            echo "No foreign keys found\n";
        } else {
            foreach ($fks as $fk) {
                echo "- {$fk['TABLE_NAME']}.{$fk['COLUMN_NAME']} -> {$fk['REFERENCED_TABLE_NAME']}.{$fk['REFERENCED_COLUMN_NAME']} (constraint: {$fk['CONSTRAINT_NAME']})\n";
            }
        }
    } catch (PDOException $e) {
        echo "❌ Error checking foreign keys: " . $e->getMessage() . "\n";
    }
    
} catch(PDOException $e) {
    die("❌ Connection failed: " . $e->getMessage() . "\n");
}

echo "\n=== Check Complete ===\n";
