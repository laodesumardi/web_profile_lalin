<?php

// Database configuration
$host = '127.0.0.1';
$username = 'root';
$password = '';
$dbname = 'laravel';

try {
    // Connect to MySQL without selecting a database
    $conn = new PDO("mysql:host=$host", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Create database if it doesn't exist
    $sql = "CREATE DATABASE IF NOT EXISTS `$dbname` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci";
    $conn->exec($sql);
    
    echo "✅ Database '$dbname' created successfully or already exists\n";
    
    // Select the database
    $conn->exec("USE `$dbname`");
    
    // Create users table if it doesn't exist
    $sql = "
    CREATE TABLE IF NOT EXISTS `users` (
        `id` bigint unsigned NOT NULL AUTO_INCREMENT,
        `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
        `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
        `email_verified_at` timestamp NULL DEFAULT NULL,
        `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
        `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
        `created_at` timestamp NULL DEFAULT NULL,
        `updated_at` timestamp NULL DEFAULT NULL,
        `nip` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
        `position` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
        `role` enum('admin','pegawai','pengunjung') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pengunjung',
        `is_active` tinyint(1) NOT NULL DEFAULT '1',
        PRIMARY KEY (`id`),
        UNIQUE KEY `users_email_unique` (`email`),
        UNIQUE KEY `users_nip_unique` (`nip`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
    
    $conn->exec($sql);
    echo "✅ Users table created successfully\n";
    
    // Create profiles table
    $sql = "
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
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
    
    $conn->exec($sql);
    echo "✅ Profiles table created successfully\n";
    
    // Create password reset tokens table
    $sql = "
    CREATE TABLE IF NOT EXISTS `password_reset_tokens` (
        `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
        `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
        `created_at` timestamp NULL DEFAULT NULL,
        PRIMARY KEY (`email`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
    
    $conn->exec($sql);
    echo "✅ Password reset tokens table created successfully\n";
    
    // Create personal access tokens table
    $sql = "
    CREATE TABLE IF NOT EXISTS `personal_access_tokens` (
        `id` bigint unsigned NOT NULL AUTO_INCREMENT,
        `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
        `tokenable_id` bigint unsigned NOT NULL,
        `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
        `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
        `abilities` text COLLATE utf8mb4_unicode_ci,
        `last_used_at` timestamp NULL DEFAULT NULL,
        `expires_at` timestamp NULL DEFAULT NULL,
        `created_at` timestamp NULL DEFAULT NULL,
        `updated_at` timestamp NULL DEFAULT NULL,
        PRIMARY KEY (`id`),
        UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
        KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
    
    $conn->exec($sql);
    echo "✅ Personal access tokens table created successfully\n";
    
    // Create sessions table
    $sql = "
    CREATE TABLE IF NOT EXISTS `sessions` (
        `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
        `user_id` bigint unsigned DEFAULT NULL,
        `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
        `user_agent` text COLLATE utf8mb4_unicode_ci,
        `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
        `last_activity` int NOT NULL,
        PRIMARY KEY (`id`),
        KEY `sessions_user_id_index` (`user_id`),
        KEY `sessions_last_activity_index` (`last_activity`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
    
    $conn->exec($sql);
    echo "✅ Sessions table created successfully\n";
    
    // Create failed jobs table
    $sql = "
    CREATE TABLE IF NOT EXISTS `failed_jobs` (
        `id` bigint unsigned NOT NULL AUTO_INCREMENT,
        `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
        `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
        `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
        `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
        `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
        `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (`id`),
        UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
    
    $conn->exec($sql);
    echo "✅ Failed jobs table created successfully\n";
    
    echo "\n✅ Database setup completed successfully!\n";
    
} catch(PDOException $e) {
    die("❌ Error: " . $e->getMessage() . "\n");
}
