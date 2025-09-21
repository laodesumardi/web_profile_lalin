<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Drop the existing profiles table if it exists
        Schema::dropIfExists('profiles');
        
        // Create a new profiles table with the correct structure
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->text('bio')->nullable();
            $table->string('photo')->nullable();
            $table->string('website')->nullable();
            $table->string('facebook')->nullable();
            $table->string('twitter')->nullable();
            $table->string('instagram')->nullable();
            $table->string('linkedin')->nullable();
            $table->string('phone')->nullable();
            $table->text('address')->nullable();
            $table->string('department')->nullable();
            $table->date('join_date')->nullable();
            $table->timestamps();
            
            // Add unique constraint on user_id
            $table->unique('user_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('profiles');
    }
};
