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
        // Add the published_at column if it doesn't exist
        if (!Schema::hasColumn('news', 'published_at')) {
            Schema::table('news', function (Blueprint $table) {
                $table->timestamp('published_at')->nullable()->after('is_published');
            });
        }
        
        // Update existing published news to have a published_at timestamp
        if (Schema::hasColumn('news', 'is_published')) {
            DB::table('news')
                ->where('is_published', true)
                ->whereNull('published_at')
                ->update(['published_at' => now()]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Don't drop the column in case it contains data
        // This is a safety measure to prevent data loss
        if (Schema::hasColumn('news', 'published_at')) {
            // If you really need to drop the column, uncomment the following:
            // Schema::table('news', function (Blueprint $table) {
            //     $table->dropColumn('published_at');
            // });
        }
    }
};
