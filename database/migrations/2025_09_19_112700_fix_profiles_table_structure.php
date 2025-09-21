<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Add missing columns to profiles table if they don't exist
        Schema::table('profiles', function (Blueprint $table) {
            if (!Schema::hasColumn('profiles', 'bio')) {
                $table->text('bio')->nullable()->after('user_id');
            }
            
            if (!Schema::hasColumn('profiles', 'photo')) {
                $table->string('photo')->nullable()->after('bio');
            }
            
            if (!Schema::hasColumn('profiles', 'website')) {
                $table->string('website')->nullable()->after('photo');
            }
            
            if (!Schema::hasColumn('profiles', 'facebook')) {
                $table->string('facebook')->nullable()->after('website');
            }
            
            if (!Schema::hasColumn('profiles', 'twitter')) {
                $table->string('twitter')->nullable()->after('facebook');
            }
            
            if (!Schema::hasColumn('profiles', 'instagram')) {
                $table->string('instagram')->nullable()->after('twitter');
            }
            
            if (!Schema::hasColumn('profiles', 'linkedin')) {
                $table->string('linkedin')->nullable()->after('instagram');
            }
        });
    }

    public function down()
    {
        // This is a one-way migration to fix the database structure
        // No rollback needed as this is fixing a broken state
    }
};
