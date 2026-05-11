<?php

namespace App\Http\Controllers;

use App\Models\Program;
use App\Models\Article;
use App\Models\GalleryAlbum;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function index()
    {
        $sitemap = '<?xml version="1.0" encoding="UTF-8"?>';
        $sitemap .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

        // Home
        $sitemap .= $this->addUrl(url('/'), now(), 'daily', '1.0');

        // Programs
        $programs = Program::active()->get();
        foreach ($programs as $program) {
            $sitemap .= $this->addUrl(
                route('programs.show', $program->slug),
                $program->updated_at,
                'weekly',
                '0.8'
            );
        }

        // Gallery Albums
        $albums = GalleryAlbum::active()->get();
        foreach ($albums as $album) {
            $sitemap .= $this->addUrl(
                route('gallery.show', $album->slug),
                $album->updated_at,
                'monthly',
                '0.6'
            );
        }

        // Static pages
        $sitemap .= $this->addUrl(route('frontend.profile.sejarah'), now(), 'monthly', '0.7');
        $sitemap .= $this->addUrl(route('frontend.profile.visi-misi'), now(), 'monthly', '0.7');
        $sitemap .= $this->addUrl(route('frontend.profile.struktur-organisasi'), now(), 'monthly', '0.7');
        $sitemap .= $this->addUrl(route('contact'), now(), 'monthly', '0.7');

        $sitemap .= '</urlset>';

        return response($sitemap, 200)
            ->header('Content-Type', 'application/xml');
    }

    private function addUrl($loc, $lastmod, $changefreq, $priority)
    {
        return '<url>' .
            '<loc>' . htmlspecialchars($loc) . '</loc>' .
            '<lastmod>' . $lastmod->format('Y-m-d') . '</lastmod>' .
            '<changefreq>' . $changefreq . '</changefreq>' .
            '<priority>' . $priority . '</priority>' .
            '</url>';
    }
}
