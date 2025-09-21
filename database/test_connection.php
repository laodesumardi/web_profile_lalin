<?php

// Database configuration
$host = '127.0.0.1';
$dbname = 'laravel';
$username = 'root';
$password = '';
$charset = 'utf8mb4';

try {
    // Create PDO connection
    $dsn = "mysql:host=$host;dbname=$dbname;charset=$charset";
    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];
    
    $pdo = new PDO($dsn, $username, $password, $options);
    
    // Test connection
    echo "✅ Successfully connected to the database.\n";
    
    // Drop profiles table if it exists
    $pdo->exec("DROP TABLE IF EXISTS profiles");
    echo "✅ Dropped existing profiles table if it existed.\n";
    
    // Create profiles table
    $sql = "CREATE TABLE profiles (
        id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        user_id BIGINT UNSIGNED NOT NULL,
        bio TEXT NULL,
        photo VARCHAR(255) NULL,
        website VARCHAR(255) NULL,
        facebook VARCHAR(255) NULL,
        twitter VARCHAR(255) NULL,
        instagram VARCHAR(255) NULL,
        linkedin VARCHAR(255) NULL,
        phone VARCHAR(20) NULL,
        address TEXT NULL,
        department VARCHAR(255) NULL,
        join_date DATE NULL,
        created_at TIMESTAMP NULL,
        updated_at TIMESTAMP NULL,
        UNIQUE KEY profiles_user_id_unique (user_id),
        CONSTRAINT profiles_user_id_foreign FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
    
    $pdo->exec($sql);
    echo "✅ Successfully created profiles table.\n";
    
    // Verify table exists
    $stmt = $pdo->query("SHOW TABLES LIKE 'profiles'");
    if ($stmt->rowCount() > 0) {
        echo "✅ Verified profiles table exists.\n";
        
        // Show table structure
        echo "\n=== PROFILES TABLE STRUCTURE ===\n";
        $columns = $pdo->query("DESCRIBE profiles")->fetchAll();
        foreach ($columns as $column) {
            echo str_pad($column['Field'], 15) . " | " . 
                 str_pad($column['Type'], 30) . " | " . 
                 str_pad($column['Null'], 5) . " | " . 
                 ($column['Key'] ?? '') . "\n";
        }
    } else {
        echo "❌ Profiles table was not created.\n";
    }
    
} catch (PDOException $e) {
    die("❌ Database error: " . $e->getMessage() . "\n");
}

echo "\n=== Script Complete ===\n";
