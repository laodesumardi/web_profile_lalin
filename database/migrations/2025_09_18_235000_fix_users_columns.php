<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class FixUsersColumns extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        // First, create a temporary column to store the role data
        Schema::table('users', function (Blueprint $table) {
            $table->string('temp_role', 20)->nullable()->after('role');
        });

        // Copy data from the old role column to the temporary column
        DB::table('users')->update([
            'temp_role' => DB::raw('role')
        ]);

        // Drop the old role column
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('role');
        });

        // Add the new role column with the correct length
        Schema::table('users', function (Blueprint $table) {
            $table->string('role', 20)->default('pegawai')->after('temp_role');
        });

        // Copy data back from the temporary column
        DB::table('users')->update([
            'role' => DB::raw('temp_role')
        ]);

        // Drop the temporary column
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('temp_role');
        });

        // Add is_active column if it doesn't exist
        if (!Schema::hasColumn('users', 'is_active')) {
            Schema::table('users', function (Blueprint $table) {
                $table->boolean('is_active')->default(true)->after('role');
            });
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
