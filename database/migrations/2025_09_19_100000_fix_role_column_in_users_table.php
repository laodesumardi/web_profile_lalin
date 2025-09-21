<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class FixRoleColumnInUsersTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // First, back up the existing role data
        $users = DB::table('users')->get();
        
        // Drop and re-add the role column with the correct type
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'role')) {
                $table->dropColumn('role');
            }
            
            $table->enum('role', ['admin', 'pegawai', 'pengunjung'])->default('pengunjung')->after('nip');
        });
        
        // Restore the role data with valid values
        foreach ($users as $user) {
            $role = 'pengunjung'; // Default role
            
            // Map existing roles to valid values
            if (in_array(strtolower($user->role ?? ''), ['admin', 'administrator', 'superadmin'])) {
                $role = 'admin';
            } elseif (in_array(strtolower($user->role ?? ''), ['pegawai', 'staff', 'employee'])) {
                $role = 'pegawai';
            }
            
            DB::table('users')
                ->where('id', $user->id)
                ->update(['role' => $role]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert back to string column if needed
        Schema::table('users', function (Blueprint $table) {
            $table->string('role')->default('pengunjung')->change();
        });
    }
};
