<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $employees = [
            [
                'name' => 'Ahmad Surya',
                'email' => 'ahmad.surya@bptd.go.id',
                'password' => Hash::make('password'),
                'nip' => '198501012020121002',
                'position' => 'Kepala Balai',
                'role' => 'pegawai',
            ],
            [
                'name' => 'Budi Santoso',
                'email' => 'budi.santoso@bptd.go.id',
                'password' => Hash::make('password'),
                'nip' => '198702152020121003',
                'position' => 'Kepala Seksi',
                'role' => 'pegawai',
            ],
            [
                'name' => 'Citra Dewi',
                'email' => 'citra.dewi@bptd.go.id',
                'password' => Hash::make('password'),
                'nip' => '199003102020121004',
                'position' => 'Staff',
                'role' => 'pegawai',
            ],
            [
                'name' => 'Dedi Kurniawan',
                'email' => 'dedi.kurniawan@bptd.go.id',
                'password' => Hash::make('password'),
                'nip' => '198804202020121005',
                'position' => 'Operator',
                'role' => 'pegawai',
            ],
            [
                'name' => 'Eka Putri',
                'email' => 'eka.putri@bptd.go.id',
                'password' => Hash::make('password'),
                'nip' => '199105152020121006',
                'position' => 'Staff',
                'role' => 'employee',
            ],
            [
                'name' => 'Fajar Ramadhan',
                'email' => 'fajar.ramadhan@bptd.go.id',
                'password' => Hash::make('password'),
                'nip' => '198606302020121007',
                'position' => 'Kepala Seksi',
                'role' => 'employee',
            ],
        ];

        foreach ($employees as $employee) {
            $user = User::create($employee);
            
            // Create profile for the user
            $user->profile()->create([
                'bio' => 'Pegawai profesional di BPTD',
                'department' => 'Teknik',
                'phone' => '08' . rand(100000000, 999999999),
                'address' => 'Jl. Contoh No. 123, Kota Bandung',
                'join_date' => now()->subYears(rand(1, 5))->subMonths(rand(0, 11))->toDateString(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
