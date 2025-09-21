<?php

require __DIR__.'/../vendor/autoload.php';

$app = require_once __DIR__.'/../bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

header('Content-Type: text/plain');

echo "=== Checking Karyawan Table ===\n\n";

// Check if karyawan table exists
if (Schema::hasTable('karyawan')) {
    echo "✅ Karyawan table exists\n";
    
    // Get columns
    $columns = Schema::getColumnListing('karyawan');
    echo "Columns in karyawan table: " . implode(', ', $columns) . "\n\n";
    
    // Get sample data
    $sampleData = DB::table('karyawan')->limit(5)->get();
    
    if ($sampleData->isNotEmpty()) {
        echo "Sample data from karyawan table:\n";
        print_r($sampleData->toArray());
    } else {
        echo "No data found in karyawan table\n";
    }
    
} else {
    echo "❌ Karyawan table does not exist\n";
    
    // Check if we should create the table
    echo "\nCreating karyawan table...\n";
    
    try {
        Schema::create('karyawan', function ($table) {
            $table->id();
            $table->string('nama');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('nip')->nullable();
            $table->string('jabatan')->nullable();
            $table->string('departemen')->nullable();
            $table->string('telepon')->nullable();
            $table->text('alamat')->nullable();
            $table->string('foto')->nullable();
            $table->boolean('is_active')->default(true);
            $table->rememberToken();
            $table->timestamps();
        });
        
        echo "✅ Karyawan table created successfully\n";
    } catch (\Exception $e) {
        echo "❌ Error creating karyawan table: " . $e->getMessage() . "\n";
    }
}

echo "\n=== Check Complete ===\n";
