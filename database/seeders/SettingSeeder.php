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
                'value' => 'Masjid Agung Al Azhar',
                'type' => 'text',
                'group' => 'general',
                'label' => 'Nama Website',
                'description' => 'Nama website yang akan ditampilkan',
                'order' => 1,
            ],
            [
                'key' => 'site_tagline',
                'value' => 'Pusat Kegiatan Keagamaan dan Dakwah',
                'type' => 'text',
                'group' => 'general',
                'label' => 'Tagline',
                'description' => 'Tagline atau slogan website',
                'order' => 2,
            ],
            [
                'key' => 'site_description',
                'value' => 'Masjid Agung Al Azhar adalah pusat kegiatan keagamaan, pendidikan, dan dakwah Islam yang berlokasi di Jakarta.',
                'type' => 'textarea',
                'group' => 'general',
                'label' => 'Deskripsi Website',
                'description' => 'Deskripsi singkat tentang website',
                'order' => 3,
            ],
            [
                'key' => 'site_logo',
                'value' => 'logo-alazhar.png',
                'type' => 'image',
                'group' => 'general',
                'label' => 'Logo Website',
                'order' => 4,
            ],
            [
                'key' => 'site_favicon',
                'value' => 'favicon.ico',
                'type' => 'image',
                'group' => 'general',
                'label' => 'Favicon',
                'order' => 5,
            ],
            [
                'key' => 'primary_color',
                'value' => '#0053C5',
                'type' => 'text',
                'group' => 'appearance',
                'label' => 'Warna Primer',
                'order' => 1,
            ],

            // Contact Information
            [
                'key' => 'contact_address',
                'value' => 'Jl. Sisingamangaraja, Kebayoran Baru, Jakarta Selatan 12110',
                'type' => 'textarea',
                'group' => 'contact',
                'label' => 'Alamat',
                'order' => 1,
            ],
            [
                'key' => 'contact_phone',
                'value' => '(021) 7394-0923',
                'type' => 'text',
                'group' => 'contact',
                'label' => 'Telepon',
                'order' => 2,
            ],
            [
                'key' => 'contact_email',
                'value' => 'info@alazhar.or.id',
                'type' => 'text',
                'group' => 'contact',
                'label' => 'Email',
                'order' => 3,
            ],
            [
                'key' => 'contact_whatsapp',
                'value' => '081234567890',
                'type' => 'text',
                'group' => 'contact',
                'label' => 'WhatsApp',
                'order' => 4,
            ],

            // Social Media
            [
                'key' => 'social_facebook',
                'value' => 'https://facebook.com/alazhar',
                'type' => 'text',
                'group' => 'social',
                'label' => 'Facebook',
                'order' => 1,
            ],
            [
                'key' => 'social_instagram',
                'value' => 'https://instagram.com/alazhar',
                'type' => 'text',
                'group' => 'social',
                'label' => 'Instagram',
                'order' => 2,
            ],
            [
                'key' => 'social_twitter',
                'value' => 'https://twitter.com/alazhar',
                'type' => 'text',
                'group' => 'social',
                'label' => 'Twitter',
                'order' => 3,
            ],
            [
                'key' => 'social_youtube',
                'value' => 'https://youtube.com/@alazhar',
                'type' => 'text',
                'group' => 'social',
                'label' => 'YouTube',
                'order' => 4,
            ],

            // SEO Settings
            [
                'key' => 'seo_title',
                'value' => 'Masjid Agung Al Azhar - Pusat Kegiatan Keagamaan dan Dakwah',
                'type' => 'text',
                'group' => 'seo',
                'label' => 'SEO Title',
                'order' => 1,
            ],
            [
                'key' => 'seo_description',
                'value' => 'Masjid Agung Al Azhar Jakarta - Pusat kegiatan ibadah, pendidikan Islam, kajian, dan dakwah. Bergabunglah bersama kami dalam membangun umat yang lebih baik.',
                'type' => 'textarea',
                'group' => 'seo',
                'label' => 'SEO Description',
                'order' => 2,
            ],
            [
                'key' => 'seo_keywords',
                'value' => 'masjid al azhar, masjid jakarta, kajian islam, pendidikan islam, dakwah',
                'type' => 'text',
                'group' => 'seo',
                'label' => 'SEO Keywords',
                'order' => 3,
            ],

            // Prayer Times
            [
                'key' => 'prayer_city',
                'value' => 'Jakarta',
                'type' => 'text',
                'group' => 'prayer',
                'label' => 'Kota',
                'order' => 1,
            ],
        ];

        foreach ($settings as $setting) {
            Setting::create($setting);
        }
    }
}
