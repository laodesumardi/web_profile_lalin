<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class AlterUsersTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Check if the users table exists
        if (Schema::hasTable('users')) {
            // Add missing columns if they don't exist
            if (!Schema::hasColumn('users', 'nip')) {
                Schema::table('users', function (Blueprint $table) {
                    $table->string('nip')->nullable()->after('password');
                });
            }
            
            if (!Schema::hasColumn('users', 'position')) {
                Schema::table('users', function (Blueprint $table) {
                    $table->string('position')->nullable()->after('nip');
                });
            }
            
            if (!Schema::hasColumn('users', 'role')) {
                Schema::table('users', function (Blueprint $table) {
                    $table->string('role', 20)->default('pengunjung')->after('position');
                });
            } else {
                // Modify the role column if it exists but has wrong type
                DB::statement("ALTER TABLE users MODIFY role VARCHAR(20) DEFAULT 'pengunjung'");
            }
            
            if (!Schema::hasColumn('users', 'is_active')) {
                Schema::table('users', function (Blueprint $table) {
                    $table->boolean('is_active')->default(true)->after('role');
                });
            } else {
                // Modify the is_active column if it exists but has wrong type
                DB::statement('ALTER TABLE users MODIFY is_active TINYINT(1) DEFAULT 1');
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // This is a safe migration, no need to implement down
    }
};
