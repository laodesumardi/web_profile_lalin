<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('profiles', function (Blueprint $table) {
            // Check if columns exist before adding them
            if (!Schema::hasColumn('profiles', 'phone')) {
                $table->string('phone')->nullable()->after('user_id');
            }
            
            if (!Schema::hasColumn('profiles', 'address')) {
                $table->text('address')->nullable()->after('phone');
            }
            
            if (!Schema::hasColumn('profiles', 'bio')) {
                $table->text('bio')->nullable()->after('address');
            }
            
            if (!Schema::hasColumn('profiles', 'photo')) {
                $table->string('photo')->nullable()->after('bio');
            }
            
            // Add any additional fields that might be needed
            $additionalFields = [
                'website',
                'facebook',
                'twitter',
                'instagram',
                'linkedin'
            ];
            
            foreach ($additionalFields as $field) {
                if (!Schema::hasColumn('profiles', $field)) {
                    $table->string($field)->nullable();
                }
            }
        });
    }

    public function down()
    {
        // We won't drop columns in the down method to prevent data loss
        // If you need to rollback, create a new migration to remove the columns
    }
};
