<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Create users table
        if (!Schema::hasTable('users')) {
            Schema::create('users', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('email')->unique();
                $table->string('nip')->unique();
                $table->string('position');
                $table->string('phone')->nullable();
                $table->text('address')->nullable();
                $table->string('photo')->nullable();
                $table->enum('role', ['admin', 'pegawai', 'pengunjung'])->default('pengunjung');
                $table->boolean('is_active')->default(false);
                $table->timestamp('email_verified_at')->nullable();
                $table->string('password');
                $table->rememberToken();
                $table->timestamps();
            });
        }

        // Create profiles table
        if (!Schema::hasTable('profiles')) {
            Schema::create('profiles', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained()->onDelete('cascade');
                // Add any additional profile fields here
                $table->text('bio')->nullable();
                $table->string('website')->nullable();
                $table->string('facebook')->nullable();
                $table->string('twitter')->nullable();
                $table->string('instagram')->nullable();
                $table->string('linkedin')->nullable();
                $table->timestamps();
            });
        }

        // Create news table if it doesn't exist
        if (!Schema::hasTable('news')) {
            Schema::create('news', function (Blueprint $table) {
                $table->id();
                $table->string('title');
                $table->string('slug')->unique();
                $table->text('content');
                $table->string('image')->nullable();
                $table->boolean('is_published')->default(false);
                $table->timestamp('published_at')->nullable();
                $table->foreignId('user_id')->constrained()->onDelete('cascade');
                $table->timestamps();
            });
        }
    }

    public function down()
    {
        // Drop tables in reverse order of creation
        Schema::dropIfExists('news');
        Schema::dropIfExists('profiles');
        Schema::dropIfExists('users');
    }
};
