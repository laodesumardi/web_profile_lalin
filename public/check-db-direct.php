<?php

// Database configuration
$host = '127.0.0.1';
$username = 'root';
$password = '';
$database = 'laravel';

try {
    // Create connection
    $conn = new PDO("mysql:host=$host;dbname=$database", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "<h2>✅ Connected to database: $database</h2>";
    
    // List all tables
    $tables = $conn->query("SHOW TABLES")->fetchAll(PDO::FETCH_COLUMN);
    
    if (empty($tables)) {
        echo "<p>No tables found in the database.</p>";
    } else {
        echo "<h3>Database Tables:</h3><ul>";
        foreach ($tables as $table) {
            echo "<li>$table</li>";
        }
        echo "</ul>";
    }
    
    // Check users table
    if (in_array('users', $tables)) {
        echo "<h3>Users Table:</h3>";
        
        // Show columns
        $columns = $conn->query("SHOW COLUMNS FROM users")->fetchAll(PDO::FETCH_COLUMN);
        echo "<p>Columns: " . implode(', ', $columns) . "</p>";
        
        // Show user count
        $userCount = $conn->query("SELECT COUNT(*) FROM users")->fetchColumn();
        echo "<p>Total users: $userCount</p>";
        
        // Show sample users
        if ($userCount > 0) {
            echo "<h4>Sample Users:</h4>";
            $users = $conn->query("SELECT id, name, email, role, is_active FROM users LIMIT 5")->fetchAll(PDO::FETCH_ASSOC);
            echo "<pre>";
            print_r($users);
            echo "</pre>";
        }
    }
    
    // Check profiles table
    if (in_array('profiles', $tables)) {
        echo "<h3>Profiles Table:</h3>";
        
        // Show columns
        $columns = $conn->query("SHOW COLUMNS FROM profiles")->fetchAll(PDO::FETCH_COLUMN);
        echo "<p>Columns: " . implode(', ', $columns) . "</p>";
        
        // Show profile count
        $profileCount = $conn->query("SELECT COUNT(*) FROM profiles")->fetchColumn();
        echo "<p>Total profiles: $profileCount</p>";
        
        // Show sample profiles with user info
        if ($profileCount > 0) {
            echo "<h4>Sample Profiles with User Info:</h4>";
            $profiles = $conn->query("
                SELECT p.*, u.name, u.email, u.role 
                FROM profiles p 
                JOIN users u ON p.user_id = u.id 
                LIMIT 5
            ")->fetchAll(PDO::FETCH_ASSOC);
            
            echo "<pre>";
            print_r($profiles);
            echo "</pre>";
        }
    }
    
} catch(PDOException $e) {
    echo "<h2>❌ Database Error</h2>";
    echo "<p>Error: " . $e->getMessage() . "</p>";
    
    // Try to connect without database to check if it exists
    try {
        $conn = new PDO("mysql:host=$host", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        // List all databases
        echo "<h3>Available Databases:</h3>";
        $databases = $conn->query("SHOW DATABASES")->fetchAll(PDO::FETCH_COLUMN);
        echo "<ul>";
        foreach ($databases as $db) {
            echo "<li>$db</li>";
        }
        echo "</ul>";
        
        // Check if the database exists
        if (in_array($database, $databases)) {
            echo "<p>Database '$database' exists but there was an error connecting to it.</p>";
        } else {
            echo "<p>Database '$database' does not exist. You may need to create it.</p>";
        }
        
    } catch(PDOException $e2) {
        echo "<p>Could not connect to MySQL server: " . $e2->getMessage() . "</p>";
    }
}

echo "<h3>PHP Info:</h3>";
echo "<p>PHP Version: " . phpversion() . "</p>";
echo "<p>PDO MySQL: " . (extension_loaded('pdo_mysql') ? 'Enabled' : 'Disabled') . "</p>";

// Check if the database configuration file exists
$envPath = __DIR__ . '/../.env';
if (file_exists($envPath)) {
    echo "<p>.env file exists.</p>";
    
    // Check database configuration in .env
    $envContent = file_get_contents($envPath);
    $dbConfig = [];
    
    // Extract DB_* variables
    if (preg_match_all('/^DB_\w+=[^\r\n]*/m', $envContent, $matches)) {
        foreach ($matches[0] as $match) {
            list($key, $value) = explode('=', $match, 2);
            $dbConfig[$key] = $value;
            echo "<p>$key = $value</p>";
        }
    }
} else {
    echo "<p>.env file not found at: $envPath</p>";
}

// Check if Laravel is properly bootstrapped
try {
    require_once __DIR__ . '/../vendor/autoload.php';
    $app = require_once __DIR__ . '/../bootstrap/app.php';
    $kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
    $kernel->bootstrap();
    
    echo "<p>✅ Laravel bootstrapped successfully</p>";
    
    // Check database connection using Laravel
    try {
        DB::connection()->getPdo();
        echo "<p>✅ Laravel database connection successful</p>";
    } catch (Exception $e) {
        echo "<p>❌ Laravel database connection failed: " . $e->getMessage() . "</p>";
    }
    
} catch (Exception $e) {
    echo "<p>❌ Laravel bootstrap failed: " . $e->getMessage() . "</p>";
}

// Add some basic styling
echo "
<style>
    body { font-family: Arial, sans-serif; margin: 20px; line-height: 1.6; }
    h2, h3, h4 { color: #2c3e50; }
    pre { background: #f5f5f5; padding: 10px; border-radius: 5px; overflow-x: auto; }
    .success { color: #27ae60; }
    .error { color: #e74c3c; }
    .info { color: #3498db; }
</style>";

// Check if we can write to storage directory
$storagePath = __DIR__ . '/../storage';
$testFile = $storagePath . '/test_write.txt';

try {
    if (file_put_contents($testFile, 'test') !== false) {
        unlink($testFile);
        echo "<p class=\"success\">✅ Storage directory is writable</p>";
    } else {
        echo "<p class=\"error\">❌ Could not write to storage directory</p>";
    }
} catch (Exception $e) {
    echo "<p class=\"error\">❌ Storage directory check failed: " . $e->getMessage() . "</p>";
}

// Check if we can connect to the database using Laravel's configuration
try {
    $config = include __DIR__ . '/../config/database.php';
    echo "<h3>Database Configuration:</h3>";
    echo "<pre>";
    print_r($config['connections']['mysql']);
    echo "</pre>";
} catch (Exception $e) {
    echo "<p class=\"error\">❌ Could not load database configuration: " . $e->getMessage() . "</p>";
}

// Check if the database exists and is accessible
try {
    $pdo = new PDO("mysql:host=$host", $username, $password);
    $stmt = $pdo->query("SHOW DATABASES LIKE '$database'");
    
    if ($stmt->rowCount() > 0) {
        echo "<p class=\"success\">✅ Database '$database' exists</p>";
        
        // Try to select the database
        try {
            $pdo->exec("USE `$database`");
            echo "<p class=\"success\">✅ Successfully selected database '$database'</p>";
            
            // Check if users table exists
            $tables = $pdo->query("SHOW TABLES")->fetchAll(PDO::FETCH_COLUMN);
            
            if (in_array('users', $tables)) {
                echo "<p class=\"success\">✅ Users table exists</p>";
                
                // Count users
                $count = $pdo->query("SELECT COUNT(*) FROM users")->fetchColumn();
                echo "<p>Total users: $count</p>";
                
                if ($count > 0) {
                    // Show first user
                    $user = $pdo->query("SELECT * FROM users LIMIT 1")->fetch(PDO::FETCH_ASSOC);
                    echo "<h4>First User:</h4><pre>";
                    print_r($user);
                    echo "</pre>";
                }
            } else {
                echo "<p class=\"error\">❌ Users table does not exist</p>";
            }
            
        } catch (PDOException $e) {
            echo "<p class=\"error\">❌ Could not select database '$database': " . $e->getMessage() . "</p>";
        }
        
    } else {
        echo "<p class=\"error\">❌ Database '$database' does not exist</p>";
    }
    
} catch (PDOException $e) {
    echo "<p class=\"error\">❌ Could not connect to MySQL server: " . $e->getMessage() . "</p>";
}

// Check if we can run Artisan commands
try {
    $output = [];
    $returnVar = 0;
    exec('php ' . __DIR__ . '/../artisan --version', $output, $returnVar);
    
    if ($returnVar === 0) {
        echo "<p class=\"success\">✅ Artisan is working: " . implode("\n", $output) . "</p>";
        
        // Try to run migrations
        $migrateOutput = [];
        $migrateReturnVar = 0;
        exec('php ' . __DIR__ . '/../artisan migrate:status', $migrateOutput, $migrateReturnVar);
        
        echo "<h4>Migration Status:</h4><pre>";
        echo implode("\n", $migrateOutput);
        echo "</pre>";
        
    } else {
        echo "<p class=\"error\">❌ Artisan is not working</p>";
    }
    
} catch (Exception $e) {
    echo "<p class=\"error\">❌ Artisan check failed: " . $e->getMessage() . "</p>";
}

// Final check for common issues
$issues = [];

// Check storage permissions
if (!is_writable(__DIR__ . '/../storage')) {
    $issues[] = "Storage directory is not writable";
}

// Check .env file
if (!file_exists(__DIR__ . '/../.env')) {
    $issues[] = ".env file is missing";
}

// Check database connection
if (!extension_loaded('pdo_mysql')) {
    $issues[] = "PDO MySQL extension is not enabled";
}

// Display issues if any
if (!empty($issues)) {
    echo "<h3>⚠️ Potential Issues:</h3><ul>";
    foreach ($issues as $issue) {
        echo "<li>$issue</li>";
    }
    echo "</ul>";
} else {
    echo "<p class=\"success\">✅ No obvious configuration issues detected</p>";
}

echo "<p>Check complete at: " . date('Y-m-d H:i:s') . "</p>";
?>
