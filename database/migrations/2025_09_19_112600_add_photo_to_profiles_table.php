<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Check if the photo column doesn't exist in the profiles table
        if (!Schema::hasColumn('profiles', 'photo')) {
            Schema::table('profiles', function (Blueprint $table) {
                $table->string('photo')->nullable()->after('user_id');
            });
        }
    }

    public function down()
    {
        // This is a one-way migration to fix the database structure
        // No rollback needed as this is fixing a broken state
    }
};
