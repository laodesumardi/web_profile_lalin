<?php

require __DIR__.'/vendor/autoload.php';

use Illuminate\Database\Capsule\Manager as DB;
use Illuminate\Database\Schema\Blueprint;

$app = require_once __DIR__.'/bootstrap/app.php';

$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

// Check if profiles table exists
if (!DB::schema()->hasTable('profiles')) {
    echo "Creating profiles table...\n";
    DB::schema()->create('profiles', function (Blueprint $table) {
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
        $table->unique('user_id');
    });
    echo "Profiles table created successfully.\n";
} else {
    // Add any missing columns
    echo "Checking profiles table structure...\n";
    $columns = [
        'bio' => function($table) { $table->text('bio')->nullable(); },
        'photo' => function($table) { $table->string('photo')->nullable(); },
        'website' => function($table) { $table->string('website')->nullable(); },
        'facebook' => function($table) { $table->string('facebook')->nullable(); },
        'twitter' => function($table) { $table->string('twitter')->nullable(); },
        'instagram' => function($table) { $table->string('instagram')->nullable(); },
        'linkedin' => function($table) { $table->string('linkedin')->nullable(); },
        'phone' => function($table) { $table->string('phone')->nullable(); },
        'address' => function($table) { $table->text('address')->nullable(); },
        'department' => function($table) { $table->string('department')->nullable(); },
        'join_date' => function($table) { $table->date('join_date')->nullable(); },
    ];

    foreach ($columns as $column => $callback) {
        if (!DB::schema()->hasColumn('profiles', $column)) {
            echo "Adding column: $column\n";
            DB::schema()->table('profiles', function($table) use ($callback) {
                $callback($table);
            });
        }
    }

    // Add foreign key if it doesn't exist
    $foreigns = DB::select("
        SELECT * FROM information_schema.TABLE_CONSTRAINTS 
        WHERE CONSTRAINT_TYPE = 'FOREIGN KEY' 
        AND TABLE_NAME = 'profiles'
        AND CONSTRAINT_NAME = 'profiles_user_id_foreign'
    ");

    if (empty($foreigns)) {
        echo "Adding foreign key constraint...\n";
        DB::statement('ALTER TABLE profiles ADD CONSTRAINT profiles_user_id_foreign FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE');
    }

    // Add unique constraint if it doesn't exist
    $uniques = DB::select("
        SELECT * FROM information_schema.TABLE_CONSTRAINTS 
        WHERE CONSTRAINT_TYPE = 'UNIQUE' 
        AND TABLE_NAME = 'profiles'
        AND CONSTRAINT_NAME = 'profiles_user_id_unique'
    ");

    if (empty($uniques)) {
        echo "Adding unique constraint...\n";
        DB::statement('ALTER TABLE profiles ADD CONSTRAINT profiles_user_id_unique UNIQUE (user_id)');
    }

    echo "Profiles table structure verified and updated.\n";
}

echo "Database check complete.\n";
