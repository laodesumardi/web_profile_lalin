<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Check if the position column exists in the profiles table
        if (Schema::hasColumn('profiles', 'position')) {
            Schema::table('profiles', function (Blueprint $table) {
                $table->dropColumn('position');
            });
        }
    }

    public function down()
    {
        // This is a one-way migration to fix the database structure
        // No rollback needed as this is fixing a broken state
    }
};
