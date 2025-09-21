<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            // Site Information
            [
                'key' => 'site_name',
                'value' => 'BPTD - Balai Pengelolaan Transportasi Darat',
                'type' => 'text',
                'group' => 'general',
                'label' => 'Nama Situs',
                'description' => 'Nama resmi instansi/organisasi',
            ],
            [
                'key' => 'site_slogan',
                'value' => 'Berkomitmen melayani masyarakat dengan profesional dan mengembangkan sistem transportasi yang aman, nyaman, dan berkelanjutan.',
                'type' => 'textarea',
                'group' => 'general',
                'label' => 'Slogan',
                'description' => 'Slogan atau tagline instansi',
            ],
            [
                'key' => 'site_copyright',
                'value' => '© ' . date('Y') . ' BPTD - Balai Pengelolaan Transportasi Darat. Semua hak dilindungi undang-undang.',
                'type' => 'text',
                'group' => 'general',
                'label' => 'Teks Hak Cipta',
                'description' => 'Teks yang muncul di footer sebagai hak cipta',
            ],

            // Contact Information
            [
                'key' => 'contact_email',
                'value' => 'info@bptd.go.id',
                'type' => 'email',
                'group' => 'contact',
                'label' => 'Email',
                'description' => 'Alamat email resmi',
            ],
            [
                'key' => 'contact_phone',
                'value' => '(021) 1234-5678',
                'type' => 'text',
                'group' => 'contact',
                'label' => 'Nomor Telepon',
                'description' => 'Nomor telepon resmi',
            ],
            [
                'key' => 'contact_address',
                'value' => "Jl. Transportasi No. 123\nJakarta Pusat, DKI Jakarta\nIndonesia 10110",
                'type' => 'textarea',
                'group' => 'contact',
                'label' => 'Alamat',
                'description' => 'Alamat lengkap instansi',
            ],

            // Footer Links
            [
                'key' => 'footer_links',
                'value' => json_encode([
                    ['title' => 'Kebijakan Privasi', 'url' => '/kebijakan-privasi'],
                    ['title' => 'Syarat & Ketentuan', 'url' => '/syarat-dan-ketentuan'],
                    ['title' => 'Sitemap', 'url' => '/sitemap.xml']
                ]),
                'type' => 'json',
                'group' => 'footer',
                'label' => 'Tautan Footer',
                'description' => 'Daftar tautan yang muncul di footer',
            ],

            // Social Media
            [
                'key' => 'social_media',
                'value' => json_encode([
                    'facebook' => 'https://facebook.com/bptd',
                    'twitter' => 'https://twitter.com/bptd',
                    'instagram' => 'https://instagram.com/bptd',
                    'youtube' => 'https://youtube.com/bptd',
                ]),
                'type' => 'json',
                'group' => 'social',
                'label' => 'Media Sosial',
                'description' => 'Akun media sosial resmi',
            ],
        ];

        foreach ($settings as $setting) {
            Setting::updateOrCreate(
                ['key' => $setting['key']],
                $setting
            );
        }
    }
}
