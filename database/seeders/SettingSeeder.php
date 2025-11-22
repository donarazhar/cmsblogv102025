<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            // General Settings
            [
                'key' => 'site_name',
                'value' => 'My Website',
                'type' => 'text',
                'group' => 'general',
                'label' => 'Nama Website',
                'description' => 'Nama website yang akan ditampilkan',
                'order' => 1,
            ],
            [
                'key' => 'site_description',
                'value' => 'Deskripsi website',
                'type' => 'textarea',
                'group' => 'general',
                'label' => 'Deskripsi Website',
                'description' => 'Deskripsi singkat tentang website',
                'order' => 2,
            ],
            [
                'key' => 'site_logo',
                'value' => null,
                'type' => 'image',
                'group' => 'general',
                'label' => 'Logo Website',
                'description' => 'Logo yang akan ditampilkan di header',
                'order' => 3,
            ],

            // Contact Settings
            [
                'key' => 'contact_email',
                'value' => 'info@example.com',
                'type' => 'email',
                'group' => 'contact',
                'label' => 'Email Kontak',
                'description' => 'Email untuk kontak',
                'order' => 1,
            ],
            [
                'key' => 'contact_phone',
                'value' => '+62 xxx xxxx xxxx',
                'type' => 'text',
                'group' => 'contact',
                'label' => 'Nomor Telepon',
                'description' => 'Nomor telepon kontak',
                'order' => 2,
            ],
            [
                'key' => 'contact_address',
                'value' => 'Alamat lengkap',
                'type' => 'textarea',
                'group' => 'contact',
                'label' => 'Alamat',
                'description' => 'Alamat lengkap kantor/toko',
                'order' => 3,
            ],

            // Social Media Settings
            [
                'key' => 'social_facebook',
                'value' => null,
                'type' => 'url',
                'group' => 'social',
                'label' => 'Facebook URL',
                'description' => 'Link halaman Facebook',
                'order' => 1,
            ],
            [
                'key' => 'social_instagram',
                'value' => null,
                'type' => 'url',
                'group' => 'social',
                'label' => 'Instagram URL',
                'description' => 'Link profil Instagram',
                'order' => 2,
            ],
            [
                'key' => 'social_twitter',
                'value' => null,
                'type' => 'url',
                'group' => 'social',
                'label' => 'Twitter URL',
                'description' => 'Link profil Twitter',
                'order' => 3,
            ],

            // SEO Settings
            [
                'key' => 'seo_keywords',
                'value' => null,
                'type' => 'textarea',
                'group' => 'seo',
                'label' => 'SEO Keywords',
                'description' => 'Kata kunci untuk SEO (pisahkan dengan koma)',
                'order' => 1,
            ],
            [
                'key' => 'seo_google_analytics',
                'value' => null,
                'type' => 'text',
                'group' => 'seo',
                'label' => 'Google Analytics ID',
                'description' => 'ID Google Analytics (contoh: UA-XXXXXXXXX-X)',
                'order' => 2,
            ],

            // Appearance Settings
            [
                'key' => 'maintenance_mode',
                'value' => '0',
                'type' => 'boolean',
                'group' => 'appearance',
                'label' => 'Mode Maintenance',
                'description' => 'Aktifkan mode maintenance website',
                'order' => 1,
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
