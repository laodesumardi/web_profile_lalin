<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class DirectFixRoleColumn extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        // For MySQL/MariaDB
        if (config('database.default') === 'mysql') {
            // First, update any existing roles to fit the new column
            DB::statement("UPDATE users SET role = 'pegawai' WHERE role NOT IN ('admin', 'pegawai') OR role IS NULL");
            
            // Then modify the column
            DB::statement("ALTER TABLE users MODIFY COLUMN role VARCHAR(20) NOT NULL DEFAULT 'pegawai'");
        }
        // For SQLite
        elseif (config('database.default') === 'sqlite') {
            // Create a new table with the correct schema
            DB::statement("
                CREATE TABLE users_new (
                    id INTEGER PRIMARY KEY AUTOINCREMENT,
                    name VARCHAR(255) NOT NULL,
                    email VARCHAR(255) NOT NULL UNIQUE,
                    email_verified_at TIMESTAMP NULL DEFAULT NULL,
                    password VARCHAR(255) NOT NULL,
                    nip VARCHAR(50) NULL DEFAULT NULL,
                    role VARCHAR(20) NOT NULL DEFAULT 'pegawai',
                    is_active BOOLEAN NOT NULL DEFAULT 1,
                    remember_token VARCHAR(100) NULL DEFAULT NULL,
                    created_at TIMESTAMP NULL DEFAULT NULL,
                    updated_at TIMESTAMP NULL DEFAULT NULL
                )
            ");
            
            // Copy data from old table to new table
            DB::statement("
                INSERT INTO users_new (id, name, email, email_verified_at, password, nip, role, is_active, remember_token, created_at, updated_at)
                SELECT id, name, email, email_verified_at, password, nip, 
                       CASE WHEN role IS NULL OR role = '' THEN 'pegawai' ELSE role END as role,
                       COALESCE(is_active, 1) as is_active,
                       remember_token, created_at, updated_at 
                FROM users
            ");
            
            // Drop old table and rename new one
            DB::statement("DROP TABLE users");
            DB::statement("ALTER TABLE users_new RENAME TO users");
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
