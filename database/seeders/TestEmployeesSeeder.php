<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class TestEmployeesSeeder extends Seeder
{
    public function run()
    {
        // Create test employees
        $employees = [
            [
                'name' => 'Ahmad Surya',
                'email' => 'ahmad.surya@bptd.test',
                'password' => Hash::make('password'),
                'nip' => '198501012020121001',
                'position' => 'Kepala Balai',
                'role' => 'pegawai',
                'is_active' => true,
                'profile' => [
                    'bio' => 'Kepala Balai yang berpengalaman di bidang transportasi darat',
                    'department' => 'Manajemen',
                    'phone' => '081234567890',
                    'address' => 'Jl. Contoh No. 1, Kota Bandung',
                    'join_date' => now()->subYears(5)->toDateString(),
                ]
            ],
            [
                'name' => 'Budi Santoso',
                'email' => 'budi.santoso@bptd.test',
                'password' => Hash::make('password'),
                'nip' => '198702152020121002',
                'position' => 'Kepala Seksi',
                'role' => 'pegawai',
                'is_active' => true,
                'profile' => [
                    'bio' => 'Kepala Seksi yang berdedikasi',
                    'department' => 'Operasional',
                    'phone' => '081234567891',
                    'address' => 'Jl. Contoh No. 2, Kota Bandung',
                    'join_date' => now()->subYears(3)->toDateString(),
                ]
            ],
            [
                'name' => 'Citra Dewi',
                'email' => 'citra.dewi@bptd.test',
                'password' => Hash::make('password'),
                'nip' => '199003102020121003',
                'position' => 'Staff',
                'role' => 'pegawai',
                'is_active' => true,
                'profile' => [
                    'bio' => 'Staff yang teliti dan profesional',
                    'department' => 'Administrasi',
                    'phone' => '081234567892',
                    'address' => 'Jl. Contoh No. 3, Kota Bandung',
                    'join_date' => now()->subYears(2)->toDateString(),
                ]
            ]
        ];

        foreach ($employees as $employeeData) {
            // Create user
            $user = User::create([
                'name' => $employeeData['name'],
                'email' => $employeeData['email'],
                'password' => $employeeData['password'],
                'nip' => $employeeData['nip'],
                'position' => $employeeData['position'],
                'role' => $employeeData['role'],
                'is_active' => $employeeData['is_active'],
                'email_verified_at' => now(),
            ]);

            // Create profile
            $user->profile()->create($employeeData['profile']);
        }

        echo "Test employees created successfully!\n";
    }
}
