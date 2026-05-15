<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Program;
use App\Models\Donation;
use App\Models\GalleryAlbum;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function index()
    {
        $sitemap = '<?xml version="1.0" encoding="UTF-8"?>';
        $sitemap .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

        // ===== STATIC / MAIN PAGES =====

        // Home (highest priority)
        $sitemap .= $this->addUrl(url('/'), now(), 'daily', '1.0');

        // Profile pages
        $sitemap .= $this->addUrl(url('/profil/sejarah'), now(), 'monthly', '0.8');
        $sitemap .= $this->addUrl(url('/profil/visi-misi'), now(), 'monthly', '0.8');
        $sitemap .= $this->addUrl(url('/profil/struktur-organisasi'), now(), 'monthly', '0.8');
        $sitemap .= $this->addUrl(url('/profil/pengurus-staf'), now(), 'monthly', '0.7');
        $sitemap .= $this->addUrl(url('/profil/fasilitas'), now(), 'monthly', '0.7');

        // Main section index pages (important for sitelinks)
        $sitemap .= $this->addUrl(url('/programs'), now(), 'weekly', '0.9');
        $sitemap .= $this->addUrl(url('/blog'), now(), 'daily', '0.9');
        $sitemap .= $this->addUrl(url('/gallery'), now(), 'weekly', '0.8');
        $sitemap .= $this->addUrl(url('/donations'), now(), 'weekly', '0.8');
        $sitemap .= $this->addUrl(url('/contact'), now(), 'monthly', '0.7');
        $sitemap .= $this->addUrl(url('/search'), now(), 'monthly', '0.5');

        // ===== DYNAMIC PAGES =====

        // Programs
        $programs = Program::where('is_active', true)->get();
        foreach ($programs as $program) {
            $sitemap .= $this->addUrl(
                url('/program/' . $program->slug),
                $program->updated_at,
                'weekly',
                '0.7'
            );
        }

        // Blog Posts
        $posts = Post::where('status', 'published')
            ->latest('published_at')
            ->limit(500)
            ->get();
        foreach ($posts as $post) {
            $sitemap .= $this->addUrl(
                url('/blog/' . $post->slug),
                $post->updated_at,
                'weekly',
                '0.7'
            );
        }

        // Gallery Albums
        $albums = GalleryAlbum::where('is_active', true)->get();
        foreach ($albums as $album) {
            $sitemap .= $this->addUrl(
                url('/gallery/' . $album->slug),
                $album->updated_at,
                'monthly',
                '0.6'
            );
        }

        // Donations
        $donations = Donation::where('is_active', true)->get();
        foreach ($donations as $donation) {
            $sitemap .= $this->addUrl(
                url('/donation/' . $donation->slug),
                $donation->updated_at,
                'weekly',
                '0.6'
            );
        }

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
