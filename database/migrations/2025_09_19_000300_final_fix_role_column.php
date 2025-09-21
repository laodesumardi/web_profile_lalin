<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class FinalFixRoleColumn extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        // First, check if the column is an enum
        $columnInfo = DB::selectOne(
            "SELECT COLUMN_TYPE, IS_NULLABLE, COLUMN_DEFAULT 
             FROM INFORMATION_SCHEMA.COLUMNS 
             WHERE TABLE_SCHEMA = ? 
             AND TABLE_NAME = 'users' 
             AND COLUMN_NAME = 'role'",
            [DB::getDatabaseName()]
        );

        if ($columnInfo) {
            // If it's an enum or has a length issue, we'll recreate it
            if (str_contains($columnInfo->COLUMN_TYPE, 'enum') || 
                (str_contains($columnInfo->COLUMN_TYPE, 'varchar') && 
                 (int) filter_var($columnInfo->COLUMN_TYPE, FILTER_SANITIZE_NUMBER_INT) < 10)) {
                
                // Create a temporary column
                DB::statement("ALTER TABLE users ADD COLUMN temp_role VARCHAR(20) DEFAULT 'pegawai'");
                
                // Copy data to temporary column
                DB::statement("UPDATE users SET temp_role = CASE 
                    WHEN role = 'admin' THEN 'admin' 
                    ELSE 'pegawai' 
                END");
                
                // Drop the old column
                DB::statement("ALTER TABLE users DROP COLUMN role");
                
                // Rename the temporary column
                DB::statement("ALTER TABLE users CHANGE temp_role role VARCHAR(20) NOT NULL DEFAULT 'pegawai'");
            }
        }

        // Ensure is_active column exists
        if (!Schema::hasColumn('users', 'is_active')) {
            DB::statement("ALTER TABLE users ADD COLUMN is_active TINYINT(1) NOT NULL DEFAULT 1");
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        // This is a one-way migration
    }
}
