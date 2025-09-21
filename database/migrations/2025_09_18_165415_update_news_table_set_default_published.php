<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Make sure the column exists before trying to modify it
        if (Schema::hasColumn('news', 'is_published')) {
            Schema::table('news', function (Blueprint $table) {
                $table->boolean('is_published')->default(false)->change();
            });
        } else {
            Schema::table('news', function (Blueprint $table) {
                $table->boolean('is_published')->default(false);
            });
        }
        
        // Add published_at if it doesn't exist
        if (!Schema::hasColumn('news', 'published_at')) {
            Schema::table('news', function (Blueprint $table) {
                $table->timestamp('published_at')->nullable()->after('is_published');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert the changes if needed
        if (Schema::hasColumn('news', 'is_published')) {
            Schema::table('news', function (Blueprint $table) {
                $table->boolean('is_published')->default(true)->change();
            });
        }
    }
};
