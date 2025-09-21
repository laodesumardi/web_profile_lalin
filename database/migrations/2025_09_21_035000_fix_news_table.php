<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Check if the table exists
        if (!Schema::hasTable('news')) {
            Schema::create('news', function (Blueprint $table) {
                $table->id();
                $table->string('title');
                $table->string('slug')->unique();
                $table->text('content');
                $table->text('excerpt')->nullable();
                $table->string('image')->nullable();
                $table->foreignId('user_id')->constrained()->onDelete('cascade');
                $table->foreignId('category_id')->constrained()->onDelete('cascade');
                $table->boolean('is_published')->default(false);
                $table->timestamp('published_at')->nullable();
                $table->unsignedInteger('views')->default(0);
                $table->timestamps();
                $table->softDeletes();
            });
        } else {
            // Add any missing columns
            Schema::table('news', function (Blueprint $table) {
                if (!Schema::hasColumn('news', 'excerpt')) {
                    $table->text('excerpt')->nullable()->after('content');
                }
                if (!Schema::hasColumn('news', 'views')) {
                    $table->unsignedInteger('views')->default(0)->after('published_at');
                }
                if (!Schema::hasColumn('news', 'deleted_at')) {
                    $table->softDeletes();
                }
            });
        }
    }

    public function down()
    {
        // Don't drop the table in the down method to prevent data loss
        Schema::table('news', function (Blueprint $table) {
            // Add any rollback logic if needed
        });
    }
};
