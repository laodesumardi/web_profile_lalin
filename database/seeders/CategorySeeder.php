<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Berita Utama',
                'slug' => 'berita-utama',
                'description' => 'Berita-berita utama dan terbaru',
                'is_active' => true,
                'order' => 1
            ],
            [
                'name' => 'Pengumuman',
                'slug' => 'pengumuman',
                'description' => 'Pengumuman resmi dari BPTD',
                'is_active' => true,
                'order' => 2
            ],
            [
                'name' => 'Kegiatan',
                'slug' => 'kegiatan',
                'description' => 'Informasi kegiatan BPTD',
                'is_active' => true,
                'order' => 3
            ],
            [
                'name' => 'Artikel',
                'slug' => 'artikel',
                'description' => 'Artikel-artikel informatif',
                'is_active' => true,
                'order' => 4
            ]
        ];

        foreach ($categories as $category) {
            \App\Models\Category::updateOrCreate(
                ['slug' => $category['slug']],
                $category
            );
        }
    }
}
