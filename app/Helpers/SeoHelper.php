<?php

namespace App\Helpers;

use Illuminate\Support\Facades\URL;

class SeoHelper
{
    public static function generateMetaTags($data = [])
    {
        $defaults = [
            'title' => setting('site_name', config('app.name')),
            'description' => setting('seo_description', 'Website resmi Masjid'),
            'keywords' => setting('seo_keywords', ''),
            'image' => setting('site_logo') ? asset('storage/' . setting('site_logo')) : asset('images/og-image.jpg'),
            'url' => URL::current(),
            'type' => 'website',
            'locale' => 'id_ID',
            'site_name' => setting('site_name', config('app.name')),
        ];

        $meta = array_merge($defaults, $data);

        return $meta;
    }

    /**
     * Generate Organization structured data (existing)
     */
    public static function generateStructuredData($type = 'Organization')
    {
        $data = [
            '@context' => 'https://schema.org',
            '@type' => $type,
            'name' => setting('site_name', config('app.name')),
            'description' => setting('seo_description', ''),
            'url' => url('/'),
            'logo' => setting('site_logo') ? asset('storage/' . setting('site_logo')) : null,
            'image' => setting('site_logo') ? asset('storage/' . setting('site_logo')) : null,
            'telephone' => setting('contact_phone', ''),
            'email' => setting('contact_email', ''),
            'address' => [
                '@type' => 'PostalAddress',
                'streetAddress' => setting('contact_address', ''),
                'addressCountry' => 'ID',
            ],
            'sameAs' => array_filter([
                setting('social_facebook'),
                setting('social_instagram'),
                setting('social_twitter'),
                setting('social_youtube'),
                setting('social_tiktok'),
            ]),
        ];

        return json_encode($data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    }

    /**
     * Generate WebSite schema with SearchAction
     * This is KEY for triggering Google Sitelinks + Search Box
     */
    public static function generateWebSiteSchema()
    {
        $data = [
            '@context' => 'https://schema.org',
            '@type' => 'WebSite',
            'name' => setting('site_name', config('app.name')),
            'alternateName' => 'MAA',
            'url' => url('/'),
            'description' => setting('seo_description', 'Website resmi Masjid Agung Al Azhar'),
            'inLanguage' => 'id-ID',
            'publisher' => [
                '@type' => 'Organization',
                'name' => setting('site_name', config('app.name')),
                'url' => url('/'),
                'logo' => [
                    '@type' => 'ImageObject',
                    'url' => setting('site_logo') ? asset('storage/' . setting('site_logo')) : asset('storage/img/ypia.png'),
                ],
            ],
            'potentialAction' => [
                '@type' => 'SearchAction',
                'target' => [
                    '@type' => 'EntryPoint',
                    'urlTemplate' => url('/search') . '?q={search_term_string}',
                ],
                'query-input' => 'required name=search_term_string',
            ],
        ];

        return json_encode($data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    }

    /**
     * Generate SiteNavigationElement schema
     * Tells Google about the main navigation structure of the website
     */
    public static function generateSiteNavigationSchema()
    {
        $navItems = [
            [
                '@type' => 'SiteNavigationElement',
                'position' => 1,
                'name' => 'Beranda',
                'description' => 'Halaman utama Masjid Agung Al Azhar',
                'url' => url('/'),
            ],
            [
                '@type' => 'SiteNavigationElement',
                'position' => 2,
                'name' => 'Sejarah',
                'description' => 'Sejarah Masjid Agung Al Azhar',
                'url' => url('/profil/sejarah'),
            ],
            [
                '@type' => 'SiteNavigationElement',
                'position' => 3,
                'name' => 'Visi & Misi',
                'description' => 'Visi dan Misi Masjid Agung Al Azhar',
                'url' => url('/profil/visi-misi'),
            ],
            [
                '@type' => 'SiteNavigationElement',
                'position' => 4,
                'name' => 'Program',
                'description' => 'Program kegiatan Masjid Agung Al Azhar',
                'url' => url('/programs'),
            ],
            [
                '@type' => 'SiteNavigationElement',
                'position' => 5,
                'name' => 'Berita',
                'description' => 'Berita dan artikel terbaru dari Masjid Agung Al Azhar',
                'url' => url('/blog'),
            ],
            [
                '@type' => 'SiteNavigationElement',
                'position' => 6,
                'name' => 'Galeri',
                'description' => 'Galeri foto dan video kegiatan Masjid Agung Al Azhar',
                'url' => url('/gallery'),
            ],
            [
                '@type' => 'SiteNavigationElement',
                'position' => 7,
                'name' => 'Donasi',
                'description' => 'Program donasi dan infaq Masjid Agung Al Azhar',
                'url' => url('/donations'),
            ],
            [
                '@type' => 'SiteNavigationElement',
                'position' => 8,
                'name' => 'Kontak',
                'description' => 'Hubungi Masjid Agung Al Azhar',
                'url' => url('/contact'),
            ],
        ];

        $data = [
            '@context' => 'https://schema.org',
            '@graph' => $navItems,
        ];

        return json_encode($data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    }

    /**
     * Generate PlaceOfWorship schema (Mosque-specific)
     * Enhances local SEO for mosque searches
     */
    public static function generatePlaceOfWorshipSchema()
    {
        $data = [
            '@context' => 'https://schema.org',
            '@type' => 'Mosque',
            'name' => setting('site_name', 'Masjid Agung Al Azhar'),
            'description' => setting('seo_description', 'Masjid Agung Al Azhar - Pusat Kegiatan Keagamaan dan Dakwah'),
            'url' => url('/'),
            'image' => setting('site_logo') ? asset('storage/' . setting('site_logo')) : asset('storage/img/ypia.png'),
            'telephone' => setting('contact_phone', ''),
            'email' => setting('contact_email', ''),
            'address' => [
                '@type' => 'PostalAddress',
                'streetAddress' => setting('contact_address', ''),
                'addressLocality' => 'Jakarta Selatan',
                'addressRegion' => 'DKI Jakarta',
                'postalCode' => '12110',
                'addressCountry' => 'ID',
            ],
            'geo' => [
                '@type' => 'GeoCoordinates',
                'latitude' => '-6.2445',
                'longitude' => '106.8454',
            ],
            'openingHoursSpecification' => [
                '@type' => 'OpeningHoursSpecification',
                'dayOfWeek' => ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'],
                'opens' => '04:00',
                'closes' => '22:00',
            ],
            'sameAs' => array_filter([
                setting('social_facebook'),
                setting('social_instagram'),
                setting('social_twitter'),
                setting('social_youtube'),
                setting('social_tiktok'),
            ]),
        ];

        return json_encode($data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    }

    /**
     * Generate Breadcrumb structured data
     */
    public static function generateBreadcrumb($items = [])
    {
        $breadcrumb = [
            '@context' => 'https://schema.org',
            '@type' => 'BreadcrumbList',
            'itemListElement' => []
        ];

        $position = 1;
        $breadcrumb['itemListElement'][] = [
            '@type' => 'ListItem',
            'position' => $position,
            'name' => 'Home',
            'item' => url('/')
        ];

        foreach ($items as $name => $url) {
            $position++;
            $breadcrumb['itemListElement'][] = [
                '@type' => 'ListItem',
                'position' => $position,
                'name' => $name,
                'item' => $url
            ];
        }

        return json_encode($breadcrumb, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    }
}
