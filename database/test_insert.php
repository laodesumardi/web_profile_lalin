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
    
    // Start transaction
    $conn->beginTransaction();
    
    // Insert test user
    $passwordHash = password_hash('password', PASSWORD_DEFAULT);
    $now = date('Y-m-d H:i:s');
    
    $sql = "INSERT INTO users (name, email, password, role, is_active, created_at, updated_at) 
            VALUES (?, ?, ?, 'admin', 1, ?, ?)";
    
    $stmt = $conn->prepare($sql);
    $stmt->execute(['Test Admin', 'admin@example.com', $passwordHash, $now, $now]);
    
    $userId = $conn->lastInsertId();
    
    // Insert test profile
    $sql = "INSERT INTO profiles (user_id, bio, created_at, updated_at) 
            VALUES (?, 'This is a test admin profile', ?, ?)";
    
    $stmt = $conn->prepare($sql);
    $stmt->execute([$userId, $now, $now]);
    
    // Commit transaction
    $conn->commit();
    
    echo "✅ Test user and profile created successfully!\n";
    echo "- Email: admin@example.com\n";
    echo "- Password: password\n";
    
    // Verify the data was inserted
    $stmt = $conn->query("SELECT u.id, u.name, u.email, u.role, p.bio FROM users u JOIN profiles p ON u.id = p.user_id WHERE u.email = 'admin@example.com'");
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($user) {
        echo "\n=== Test User Data ===\n";
        foreach ($user as $key => $value) {
            echo "$key: $value\n";
        }
    }
    
} catch(PDOException $e) {
    // Rollback transaction on error
    if (isset($conn)) {
        $conn->rollBack();
    }
    die("❌ Error: " . $e->getMessage() . "\n");
}

echo "\n=== Test Complete ===\n";
