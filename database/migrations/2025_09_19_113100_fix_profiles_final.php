<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        // Drop existing foreign key constraints
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        
        // Drop existing profiles table if it exists
        DB::statement('DROP TABLE IF EXISTS profiles');
        
        // Create new profiles table with correct structure using raw SQL
        DB::statement('CREATE TABLE profiles (
            id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            user_id BIGINT UNSIGNED NOT NULL,
            bio TEXT NULL,
            photo VARCHAR(255) NULL,
            website VARCHAR(255) NULL,
            facebook VARCHAR(255) NULL,
            twitter VARCHAR(255) NULL,
            instagram VARCHAR(255) NULL,
            linkedin VARCHAR(255) NULL,
            phone VARCHAR(20) NULL,
            address TEXT NULL,
            department VARCHAR(255) NULL,
            join_date DATE NULL,
            created_at TIMESTAMP NULL,
            updated_at TIMESTAMP NULL,
            UNIQUE KEY profiles_user_id_unique (user_id),
            CONSTRAINT profiles_user_id_foreign FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci');
        
        // Re-enable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }

    public function down()
    {
        // This is a one-way migration to fix the database structure
        // No rollback needed as this is fixing a broken state
    }
};
