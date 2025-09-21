<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class FixProfilesOnceAndForAll extends Migration
{
    public function up()
    {
        // Drop existing profiles table if it exists
        $this->dropExistingTable();
        
        // Create new profiles table with proper structure
        $this->createProfilesTable();
    }
    
    protected function dropExistingTable()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        
        // Check if the table exists before trying to drop it
        $tableExists = DB::select("SHOW TABLES LIKE 'profiles'");
        
        if (!empty($tableExists)) {
            DB::statement('DROP TABLE IF EXISTS profiles');
        }
        
        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }
    
    protected function createProfilesTable()
    {
        $sql = <<<SQL
        CREATE TABLE IF NOT EXISTS `profiles` (
            `id` bigint unsigned NOT NULL AUTO_INCREMENT,
            `user_id` bigint unsigned NOT NULL,
            `bio` text COLLATE utf8mb4_unicode_ci,
            `photo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
            `website` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
            `facebook` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
            `twitter` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
            `instagram` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
            `linkedin` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
            `phone` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
            `address` text COLLATE utf8mb4_unicode_ci,
            `department` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
            `join_date` date DEFAULT NULL,
            `created_at` timestamp NULL DEFAULT NULL,
            `updated_at` timestamp NULL DEFAULT NULL,
            PRIMARY KEY (`id`),
            UNIQUE KEY `profiles_user_id_unique` (`user_id`),
            CONSTRAINT `profiles_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
        SQL;
        
        DB::statement($sql);
    }

    public function down()
    {
        // This is a one-way migration to fix the database structure
        // No rollback needed as this is fixing a broken state
    }
}
