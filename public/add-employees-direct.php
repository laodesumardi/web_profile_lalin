<?php

// Database configuration
$host = '127.0.0.1';
$username = 'root';
$password = '';
$database = 'laravel';

header('Content-Type: text/plain');

echo "=== Adding Test Employees Directly ===\n\n";

try {
    // Connect to the database
    $conn = new PDO("mysql:host=$host;dbname=$database", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Start transaction
    $conn->beginTransaction();
    
    // Test employee data
    $employees = [
        [
            'name' => 'Ahmad Surya',
            'email' => 'ahmad.surya@bptd.test',
            'password' => password_hash('password', PASSWORD_DEFAULT),
            'nip' => '198501012020121001',
            'position' => 'Kepala Balai',
            'role' => 'pegawai',
            'is_active' => 1,
            'email_verified_at' => date('Y-m-d H:i:s'),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ],
        [
            'name' => 'Budi Santoso',
            'email' => 'budi.santoso@bptd.test',
            'password' => password_hash('password', PASSWORD_DEFAULT),
            'nip' => '198702152020121002',
            'position' => 'Kepala Seksi',
            'role' => 'pegawai',
            'is_active' => 1,
            'email_verified_at' => date('Y-m-d H:i:s'),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ],
        [
            'name' => 'Citra Dewi',
            'email' => 'citra.dewi@bptd.test',
            'password' => password_hash('password', PASSWORD_DEFAULT),
            'nip' => '199003102020121003',
            'position' => 'Staff',
            'role' => 'pegawai',
            'is_active' => 1,
            'email_verified_at' => date('Y-m-d H:i:s'),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]
    ];
    
    $addedCount = 0;
    
    foreach ($employees as $employee) {
        // Check if user already exists
        $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->execute([$employee['email']]);
        $existingUser = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if (!$existingUser) {
            // Insert user
            $sql = "INSERT INTO users (name, email, password, nip, position, role, is_active, email_verified_at, created_at, updated_at) 
                    VALUES (:name, :email, :password, :nip, :position, :role, :is_active, :email_verified_at, :created_at, :updated_at)";
            
            $stmt = $conn->prepare($sql);
            $stmt->execute($employee);
            
            $userId = $conn->lastInsertId();
            
            // Insert profile
            $profileSql = "INSERT INTO profiles (user_id, bio, department, phone, address, join_date, created_at, updated_at) 
                          VALUES (:user_id, :bio, :department, :phone, :address, :join_date, :created_at, :updated_at)";
            
            $profileData = [
                'user_id' => $userId,
                'bio' => 'Pegawai profesional di BPTD',
                'department' => 'Teknik',
                'phone' => '08' . rand(100000000, 999999999),
                'address' => 'Jl. Contoh No. 123, Kota Bandung',
                'join_date' => date('Y-m-d', strtotime('-' . rand(1, 5) . ' years -' . rand(0, 11) . ' months')),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ];
            
            $stmt = $conn->prepare($profileSql);
            $stmt->execute($profileData);
            
            echo "✅ Added employee: {$employee['name']} ({$employee['email']})\n";
            $addedCount++;
        } else {
            echo "ℹ️ Employee already exists: {$employee['name']} ({$employee['email']})\n";
        }
    }
    
    // Commit transaction
    $conn->commit();
    
    // Count total employees
    $stmt = $conn->query("SELECT COUNT(*) FROM users WHERE role = 'pegawai'");
    $employeeCount = $stmt->fetchColumn();
    
    echo "\n=== Summary ===\n";
    echo "Total employees in database: $employeeCount\n";
    echo "Employees added in this run: $addedCount\n";
    
} catch(PDOException $e) {
    // Rollback transaction on error
    if (isset($conn) && $conn->inTransaction()) {
        $conn->rollBack();
    }
    
    echo "\n❌ Error: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . ":" . $e->getLine() . "\n";
    
    // Show SQL error if available
    if (isset($stmt)) {
        echo "SQL: " . $stmt->queryString . "\n";
    }
}

echo "\n=== Script Complete ===\n";
