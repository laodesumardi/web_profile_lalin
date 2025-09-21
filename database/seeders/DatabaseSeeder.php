<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create default categories
        // Setup roles and permissions first
        $this->call([
            RolePermissionSeeder::class,
        ]);

        // Then seed categories and other data
        $this->call([
            CategorySeeder::class,
            SettingsTableSeeder::class,
            AdminSeeder::class,
            EmployeeSeeder::class,
            TestEmployeesSeeder::class,
        ]);
    }
}
