<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@bptd.go.id',
            'password' => Hash::make('admin123'),
            'nip' => '199001012020121001',
            'position' => 'Administrator',
            'role' => 'admin',
        ]);
    }
}
