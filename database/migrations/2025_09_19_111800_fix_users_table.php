<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Make nip nullable temporarily to allow existing records
        Schema::table('users', function (Blueprint $table) {
            $table->string('nip')->nullable()->change();
            
            // Add other required fields if they don't exist
            $columns = [
                'position' => 'string',
                'phone' => 'string',
                'address' => 'text',
                'photo' => 'string',
                'role' => 'string',
                'is_active' => 'boolean'
            ];
            
            foreach ($columns as $column => $type) {
                if (!Schema::hasColumn('users', $column)) {
                    if ($type === 'boolean') {
                        $table->boolean($column)->default(false);
                    } elseif ($type === 'text') {
                        $table->text($column)->nullable();
                    } else {
                        $table->string($column)->nullable();
                    }
                }
            }
        });
        
        // Update existing admin user with default values
        DB::table('users')->update([
            'nip' => '000000000000000000',
            'position' => 'Administrator',
            'role' => 'admin',
            'is_active' => true,
            'updated_at' => now()
        ]);
        
        // Make nip required after updating existing records
        Schema::table('users', function (Blueprint $table) {
            $table->string('nip')->nullable(false)->change();
        });
    }

    public function down()
    {
        // This is a one-way migration to fix the database structure
        // No rollback needed as this is fixing a broken state
    }
};
