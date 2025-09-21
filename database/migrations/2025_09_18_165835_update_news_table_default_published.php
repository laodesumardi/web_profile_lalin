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
        // First, drop the existing default value if it exists
        Schema::table('news', function (Blueprint $table) {
            $table->boolean('is_published')->default(false)->change();
        });
        
        // Add the published_at column if it doesn't exist
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
        // Revert the default value back to true
        Schema::table('news', function (Blueprint $table) {
            $table->boolean('is_published')->default(true)->change();
        });
        
        // Don't drop published_at as it might contain data
    }
};
