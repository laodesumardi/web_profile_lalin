<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class FixUsersRoleColumn extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        // First, make sure the column exists
        if (Schema::hasColumn('users', 'role')) {
            // Drop and re-add the column with the correct type
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('role');
            });
        }

        // Add the column with the correct type
        Schema::table('users', function (Blueprint $table) {
            $table->string('role', 20)->default('pegawai')->after('nip');
        });

        // Add is_active if it doesn't exist
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
