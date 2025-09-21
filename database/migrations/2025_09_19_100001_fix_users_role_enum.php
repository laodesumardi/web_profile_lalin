<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class FixUsersRoleEnum extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // First, create a temporary column to store the role values
        Schema::table('users', function (Blueprint $table) {
            $table->string('temp_role', 20)->after('role');
        });
        
        // Copy the existing role values to the temporary column
        DB::table('users')->update([
            'temp_role' => DB::raw('CASE 
                WHEN role = "admin" OR role = "administrator" OR role = "superadmin" THEN "admin"
                WHEN role = "pegawai" OR role = "staff" OR role = "employee" THEN "pegawai"
                ELSE "pengunjung"
            END')
        ]);
        
        // Drop the original role column
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('role');
        });
        
        // Add the role column with the correct enum type
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['admin', 'pegawai', 'pengunjung'])->default('pengunjung')->after('nip');
        });
        
        // Copy the values back from the temporary column
        DB::table('users')->update([
            'role' => DB::raw('temp_role')
        ]);
        
        // Drop the temporary column
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('temp_role');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // If we need to rollback, just convert back to a string
        Schema::table('users', function (Blueprint $table) {
            $table->string('role')->default('pengunjung')->change();
        });
    }
};
