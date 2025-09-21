<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class FixRoleColumnAgain extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        // First, create a backup of the current users table
        if (!Schema::hasTable('users_backup')) {
            DB::statement('CREATE TABLE users_backup LIKE users');
            DB::statement('INSERT users_backup SELECT * FROM users');
        }

        // Get the current table definition
        $tableName = DB::getTablePrefix() . 'users';
        $dbName = DB::connection()->getDatabaseName();
        
        // Check if the role column is an enum
        $columnType = DB::selectOne(
            "SELECT COLUMN_TYPE FROM INFORMATION_SCHEMA.COLUMNS 
            WHERE TABLE_SCHEMA = ? AND TABLE_NAME = ? AND COLUMN_NAME = 'role'",
            [$dbName, 'users']
        );

        if ($columnType && str_contains($columnType->COLUMN_TYPE, 'enum')) {
            // If role is an enum, we need to drop and recreate it
            DB::statement("ALTER TABLE users MODIFY COLUMN role VARCHAR(20) NOT NULL DEFAULT 'pegawai'");
        } else {
            // If not an enum, just modify the column
            DB::statement("ALTER TABLE users MODIFY COLUMN role VARCHAR(20) NOT NULL DEFAULT 'pegawai'");
        }

        // Ensure is_active column exists
        if (!Schema::hasColumn('users', 'is_active')) {
            Schema::table('users', function (Blueprint $table) {
                $table->boolean('is_active')->default(true)->after('role');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        // Restore from backup if needed
        if (Schema::hasTable('users_backup')) {
            DB::statement('TRUNCATE TABLE users');
            DB::statement('INSERT users SELECT * FROM users_backup');
            DB::statement('DROP TABLE users_backup');
        }
    }
}
