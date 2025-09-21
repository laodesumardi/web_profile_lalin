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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->string('group')->default('general');
            $table->string('type')->default('text');
            $table->text('options')->nullable();
            $table->string('label');
            $table->text('description')->nullable();
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        // Insert default settings
        DB::table('settings')->insert([
            [
                'key' => 'site_name',
                'value' => config('app.name'),
                'group' => 'general',
                'type' => 'text',
                'label' => 'Nama Situs',
                'description' => 'Nama resmi instansi/organisasi',
                'sort_order' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'site_description',
                'value' => 'Website Resmi BPTD',
                'group' => 'general',
                'type' => 'textarea',
                'label' => 'Deskripsi Situs',
                'description' => 'Deskripsi singkat tentang situs',
                'sort_order' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'contact_email',
                'value' => 'info@bptd.example.com',
                'group' => 'general',
                'type' => 'email',
                'label' => 'Email Kontak',
                'description' => 'Email yang dapat dihubungi',
                'sort_order' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'items_per_page',
                'value' => '10',
                'group' => 'general',
                'type' => 'number',
                'label' => 'Item Per Halaman',
                'description' => 'Jumlah item yang ditampilkan per halaman',
                'sort_order' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
