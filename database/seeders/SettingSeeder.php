<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            // General
            ['key' => 'site_name', 'label' => 'Site Name', 'value' => 'Masjid Agung Al Azhar', 'type' => 'text', 'group' => 'general', 'order' => 1],
            ['key' => 'site_description', 'label' => 'Site Description', 'value' => 'Pusat kegiatan keagamaan, pendidikan, dan dakwah Islam di Jakarta.', 'type' => 'textarea', 'group' => 'general', 'order' => 2],
            ['key' => 'site_logo', 'label' => 'Site Logo', 'value' => null, 'type' => 'image', 'group' => 'general', 'order' => 3],
            ['key' => 'site_favicon', 'label' => 'Site Favicon', 'value' => null, 'type' => 'image', 'group' => 'general', 'order' => 4],

            // Contact
            ['key' => 'contact_address', 'label' => 'Address', 'value' => 'Jakarta, Indonesia', 'type' => 'textarea', 'group' => 'contact', 'order' => 1],
            ['key' => 'contact_phone', 'label' => 'Phone', 'value' => '(+62) 217397267', 'type' => 'text', 'group' => 'contact', 'order' => 2],
            ['key' => 'contact_email', 'label' => 'Email', 'value' => 'masjidagungalazhar@gmail.com', 'type' => 'email', 'group' => 'contact', 'order' => 3],
            ['key' => 'contact_whatsapp', 'label' => 'WhatsApp', 'value' => '0882-1211-4771', 'type' => 'text', 'group' => 'contact', 'order' => 4],

            // Social Media
            ['key' => 'social_facebook', 'label' => 'Facebook URL', 'value' => null, 'type' => 'url', 'group' => 'social', 'order' => 1],
            ['key' => 'social_instagram', 'label' => 'Instagram URL', 'value' => null, 'type' => 'url', 'group' => 'social', 'order' => 2],
            ['key' => 'social_twitter', 'label' => 'Twitter URL', 'value' => null, 'type' => 'url', 'group' => 'social', 'order' => 3],
            ['key' => 'social_youtube', 'label' => 'YouTube URL', 'value' => null, 'type' => 'url', 'group' => 'social', 'order' => 4],
            ['key' => 'social_tiktok', 'label' => 'TikTok URL', 'value' => null, 'type' => 'url', 'group' => 'social', 'order' => 5], // ✅ TAMBAHKAN
            // SEO
            ['key' => 'seo_description', 'label' => 'Meta Description', 'value' => 'Masjid Agung Al Azhar - Pusat Kegiatan Keagamaan dan Dakwah', 'type' => 'textarea', 'group' => 'seo', 'order' => 1],
            ['key' => 'seo_keywords', 'label' => 'Meta Keywords', 'value' => 'masjid al azhar, masjid jakarta, kajian islam', 'type' => 'textarea', 'group' => 'seo', 'order' => 2],

            // Operational
            ['key' => 'operational_weekday', 'label' => 'Weekday Hours', 'value' => 'Senin - Sabtu: 08:00 - 15:00', 'type' => 'text', 'group' => 'general', 'order' => 10],
            ['key' => 'operational_sunday', 'label' => 'Sunday Hours', 'value' => 'Ahad: Janji Temu', 'type' => 'text', 'group' => 'general', 'order' => 11],
            ['key' => 'operational_friday', 'label' => 'Friday Prayer', 'value' => 'Jumat: 11:30 - 12:30 (Sholat Jumat)', 'type' => 'text', 'group' => 'general', 'order' => 12],

            // Developer
            ['key' => 'developer_name', 'label' => 'Developer Name', 'value' => 'DAL ARMY', 'type' => 'text', 'group' => 'general', 'order' => 20],
        ];

        foreach ($settings as $setting) {
            Setting::updateOrCreate(
                ['key' => $setting['key']],
                $setting
            );
        }
    }
}
