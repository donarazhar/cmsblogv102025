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
