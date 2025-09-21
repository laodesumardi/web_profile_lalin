<?php

require __DIR__.'/../vendor/autoload.php';

$app = require_once __DIR__.'/../bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

header('Content-Type: text/plain');

echo "=== Adding Test Employees ===\n\n";

try {
    // Start transaction
    DB::beginTransaction();
    
    // Test employee data
    $employees = [
        [
            'name' => 'Ahmad Surya',
            'email' => 'ahmad.surya@bptd.test',
            'password' => Hash::make('password'),
            'nip' => '198501012020121001',
            'position' => 'Kepala Balai',
            'role' => 'pegawai',
            'is_active' => true,
            'email_verified_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ],
        [
            'name' => 'Budi Santoso',
            'email' => 'budi.santoso@bptd.test',
            'password' => Hash::make('password'),
            'nip' => '198702152020121002',
            'position' => 'Kepala Seksi',
            'role' => 'pegawai',
            'is_active' => true,
            'email_verified_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ],
        [
            'name' => 'Citra Dewi',
            'email' => 'citra.dewi@bptd.test',
            'password' => Hash::make('password'),
            'nip' => '199003102020121003',
            'position' => 'Staff',
            'role' => 'pegawai',
            'is_active' => true,
            'email_verified_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]
    ];
    
    $addedCount = 0;
    
    foreach ($employees as $employeeData) {
        // Check if user already exists
        $existingUser = User::where('email', $employeeData['email'])->first();
        
        if (!$existingUser) {
            // Create user
            $user = User::create($employeeData);
            
            // Create profile
            $user->profile()->create([
                'bio' => 'Pegawai profesional di BPTD',
                'department' => 'Teknik',
                'phone' => '08' . rand(100000000, 999999999),
                'address' => 'Jl. Contoh No. 123, Kota Bandung',
                'join_date' => now()->subYears(rand(1, 5))->subMonths(rand(0, 11))->toDateString(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            
            echo "✅ Added employee: {$user->name} ({$user->email})\n";
            $addedCount++;
        } else {
            echo "ℹ️ Employee already exists: {$existingUser->name} ({$existingUser->email})\n";
        }
    }
    
    // Commit transaction
    DB::commit();
    
    echo "\n=== Summary ===\n";
    echo "Total employees in database: " . User::where('role', 'pegawai')->count() . "\n";
    echo "Employees added in this run: $addedCount\n";
    
} catch (\Exception $e) {
    // Rollback transaction on error
    DB::rollBack();
    
    echo "\n❌ Error: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . ":" . $e->getLine() . "\n";
    
    // Show SQL error if available
    if (method_exists($e, 'getSql')) {
        echo "SQL: " . $e->getSql() . "\n";
        echo "Bindings: " . print_r($e->getBindings(), true) . "\n";
    }
}

echo "\n=== Script Complete ===\n";
