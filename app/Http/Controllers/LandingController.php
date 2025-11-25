<?php

namespace App\Http\Controllers;

use App\Models\{
    Announcement,
    Category,
    Contact,
    Donation,
    DonationTransaction,
    Gallery,
    GalleryAlbum,
    Page,
    Post,
    Program,
    Schedule,
    Slider,
    Staff,
    Testimonial
};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class LandingController extends Controller
{
    public function index()
    {
        // Cache ALL data in one go - 5 minutes cache
        $data = Cache::remember('landing_page_complete_v3', 300, function () {
            return [
                // Hero Sliders
                'sliders' => Slider::active()
                    ->ordered()
                    ->select('id', 'title', 'subtitle', 'description', 'image', 'button_text', 'button_link', 'button_text_2', 'button_link_2', 'text_position', 'overlay_color', 'overlay_opacity')
                    ->limit(5)
                    ->get(),

                // Announcements
                'announcements' => Announcement::active()
                    ->onHomepage()
                    ->byPriority()
                    ->ordered()
                    ->select('id', 'title', 'type', 'priority')
                    ->limit(5)
                    ->get(),

                // Programs
                'programs' => Program::active()
                    ->featured()
                    ->ordered()
                    ->select('id', 'name', 'slug', 'description', 'image', 'icon', 'type', 'frequency', 'location', 'start_time')
                    ->limit(4)
                    ->get(),

                // Latest Posts
                'latestPosts' => Post::published()
                    ->whereHas('category')
                    ->whereHas('author')
                    ->with(['category:id,name,slug', 'author:id,name'])
                    ->select('id', 'title', 'slug', 'excerpt', 'featured_image', 'published_at', 'category_id', 'author_id', 'views_count')
                    ->latest('published_at')
                    ->limit(6)
                    ->get(),

                // Featured Posts
                'featuredPosts' => Post::published()
                    ->featured()
                    ->whereHas('category')
                    ->whereHas('author')
                    ->with(['category:id,name,slug', 'author:id,name'])
                    ->select('id', 'title', 'slug', 'excerpt', 'featured_image', 'published_at', 'category_id', 'author_id', 'views_count')
                    ->limit(3)
                    ->get(),

                // Gallery
                'galleries' => Gallery::active()
                    ->featured()
                    ->images()
                    ->ordered()
                    ->select('id', 'title', 'description', 'image')
                    ->limit(6)
                    ->get(),

                // Gallery Albums
                'albums' => GalleryAlbum::active()
                    ->withCount('galleries')
                    ->latest('event_date')
                    ->select('id', 'name', 'slug', 'cover_image', 'event_date')
                    ->limit(3)
                    ->get(),

                // Today's Schedule
                'todaySchedules' => Schedule::active()
                    ->today()
                    ->orderBy('start_time', 'asc')
                    ->select('id', 'title', 'type', 'start_time', 'end_time', 'location', 'imam', 'speaker', 'color')
                    ->limit(3)
                    ->get(),

                // Upcoming Events
                'upcomingEvents' => Schedule::active()
                    ->where('type', 'event')
                    ->upcoming(30)
                    ->select('id', 'title', 'date', 'start_time', 'end_time', 'location')
                    ->limit(3)
                    ->get(),

                // Testimonials
                'testimonials' => Testimonial::approved()
                    ->featured()
                    ->ordered()
                    ->select('id', 'name', 'role', 'company', 'content', 'photo', 'rating')
                    ->limit(6)
                    ->get(),

                // Donations
                'donations' => Donation::active()
                    ->ongoing()
                    ->featured()
                    ->ordered()
                    ->select('id', 'campaign_name', 'slug', 'description', 'image', 'category', 'target_amount', 'current_amount', 'donor_count', 'end_date')
                    ->limit(3)
                    ->get(),

                // Categories
                'categories' => Category::active()
                    ->withCount(['posts' => function ($query) {
                        $query->where('status', 'published');
                    }])
                    ->ordered()
                    ->select('id', 'name', 'slug', 'description', 'icon')
                    ->limit(3)
                    ->get(),
            ];
        });

        return view('landing.index', array_merge($data, [
            'pageTitle' => 'Beranda',
            'pageDescription' => 'Masjid Agung Al Azhar - Pusat Kegiatan Keagamaan dan Dakwah Islam di Jakarta',
            'pageKeywords' => 'masjid al azhar, masjid jakarta, kajian islam, sholat jumat',
            'breadcrumb' => [],
        ]));
    }

    public function about()
    {
        $data = Cache::remember('about_page_data_v2', 300, function () {
            return [
                'staff' => Staff::active()
                    ->ordered()
                    ->select('id', 'name', 'slug', 'position', 'department', 'photo', 'biography', 'email', 'phone')
                    ->get(),
            ];
        });

        return view('landing.about', $data);
    }

    public function programs()
    {
        $programs = Program::active()
            ->ordered()
            ->select('id', 'name', 'slug', 'description', 'image', 'type', 'frequency', 'location', 'start_date', 'start_time', 'registration_fee')
            ->paginate(12);

        return view('landing.programs', compact('programs'));
    }

    public function programDetail($slug)
    {
        $data = Cache::remember("program_detail_{$slug}_v2", 600, function () use ($slug) {
            $program = Program::where('slug', $slug)
                ->where('is_active', true)
                ->firstOrFail();

            $relatedPrograms = Program::active()
                ->where('id', '!=', $program->id)
                ->where('type', $program->type)
                ->select('id', 'name', 'slug', 'description', 'image', 'type', 'icon')
                ->limit(3)
                ->get();

            return compact('program', 'relatedPrograms');
        });

        return view('landing.program-detail', $data);
    }

    public function blog(Request $request)
    {
        $query = Post::published()
            ->whereHas('category')
            ->whereHas('author')
            ->with([
                'category:id,name,slug',
                'author:id,name',
                'tags:id,name,slug'
            ])
            ->select('id', 'title', 'slug', 'excerpt', 'featured_image', 'published_at', 'category_id', 'author_id', 'views_count', 'reading_time');

        if ($request->filled('category')) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        if ($request->filled('tag')) {
            $query->whereHas('tags', function ($q) use ($request) {
                $q->where('slug', $request->tag);
            });
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('excerpt', 'like', "%{$search}%")
                    ->orWhere('content', 'like', "%{$search}%");
            });
        }

        $posts = $query->latest('published_at')->paginate(6);

        $sidebarData = Cache::remember('blog_sidebar_data_v2', 300, function () {
            return [
                'categories' => Category::active()
                    ->withCount(['posts' => function ($q) {
                        $q->where('status', 'published');
                    }])
                    ->ordered()
                    ->select('id', 'name', 'slug')
                    ->get(),

                'popularPosts' => Post::published()
                    ->whereHas('category')
                    ->orderBy('views_count', 'desc')
                    ->select('id', 'title', 'slug', 'featured_image', 'published_at', 'category_id')
                    ->with('category:id,name,slug')
                    ->limit(5)
                    ->get(),
            ];
        });

        return view('landing.blog', array_merge(compact('posts'), $sidebarData));
    }

    public function blogDetail($slug)
    {
        $post = Post::where('slug', $slug)
            ->where('status', 'published')
            ->with([
                'category:id,name,slug',
                'author:id,name',
                'tags:id,name,slug',
                'approvedComments.user:id,name'
            ])
            ->firstOrFail();

        dispatch(function () use ($post) {
            $post->increment('views_count');
        })->afterResponse();

        $relatedPosts = Cache::remember("related_posts_cat_{$post->category_id}_v2", 300, function () use ($post) {
            return Post::published()
                ->whereHas('category')
                ->whereHas('author')
                ->where('id', '!=', $post->id)
                ->where('category_id', $post->category_id)
                ->with([
                    'category:id,name,slug',
                    'author:id,name'
                ])
                ->select('id', 'title', 'slug', 'excerpt', 'featured_image', 'published_at', 'category_id', 'author_id')
                ->limit(3)
                ->get();
        });

        return view('landing.blog-detail', compact('post', 'relatedPosts'));
    }

    public function gallery()
    {
        $albums = GalleryAlbum::active()
            ->withCount('galleries')
            ->latest('event_date')
            ->select('id', 'name', 'slug', 'description', 'cover_image', 'event_date')
            ->paginate(12);

        return view('landing.gallery', compact('albums'));
    }

    public function galleryAlbum($slug)
    {
        $data = Cache::remember("gallery_album_{$slug}_v2", 600, function () use ($slug) {
            $album = GalleryAlbum::where('slug', $slug)
                ->where('is_active', true)
                ->firstOrFail();

            $galleries = Gallery::where('album_id', $album->id)
                ->where('is_active', true)
                ->ordered()
                ->select('id', 'title', 'description', 'image', 'type')
                ->get();

            return compact('album', 'galleries');
        });

        return view('landing.gallery-album', $data);
    }

    public function contact()
    {
        return view('landing.contact');
    }

    public function contactSubmit(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:1000',
        ], [
            'name.required' => 'Nama harus diisi',
            'email.required' => 'Email harus diisi',
            'email.email' => 'Format email tidak valid',
            'subject.required' => 'Subjek harus diisi',
            'message.required' => 'Pesan harus diisi',
        ]);

        Contact::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'subject' => $request->subject,
            'message' => $request->message,
            'status' => 'new',
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return back()->with('success', 'Terima kasih! Pesan Anda telah terkirim. Kami akan segera menghubungi Anda.');
    }

    public function donations()
    {
        $donations = Donation::active()
            ->ongoing()
            ->ordered()
            ->select('id', 'campaign_name', 'slug', 'description', 'image', 'category', 'target_amount', 'current_amount', 'donor_count', 'end_date')
            ->paginate(12);

        $cachedData = Cache::remember('donations_page_data_v2', 300, function () {
            return [
                'featuredDonations' => Donation::active()
                    ->featured()
                    ->ongoing()
                    ->ordered()
                    ->select('id', 'campaign_name', 'slug', 'description', 'image', 'target_amount', 'current_amount', 'donor_count')
                    ->limit(3)
                    ->get(),

                'stats' => [
                    'total_collected' => Donation::sum('current_amount'),
                    'total_donors' => DonationTransaction::where('status', 'verified')->distinct('donor_email')->count(),
                    'active_campaigns' => Donation::active()->ongoing()->count(),
                ],
            ];
        });

        return view('landing.donations', array_merge(compact('donations'), $cachedData));
    }

    public function donationDetail($slug)
    {
        $donation = Donation::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        $recentDonations = DonationTransaction::where('donation_id', $donation->id)
            ->where('status', 'verified')
            ->where('is_anonymous', false)
            ->select('id', 'donor_name', 'amount', 'created_at')
            ->latest()
            ->limit(10)
            ->get();

        $relatedDonations = Cache::remember("related_donations_cat_{$donation->category}_v2", 300, function () use ($donation) {
            return Donation::active()
                ->ongoing()
                ->where('id', '!=', $donation->id)
                ->where('category', $donation->category)
                ->select('id', 'campaign_name', 'slug', 'image', 'target_amount', 'current_amount')
                ->limit(3)
                ->get();
        });

        return view('landing.donation-detail', compact('donation', 'recentDonations', 'relatedDonations'));
    }

    public function page($slug)
    {
        $page = Page::where('slug', $slug)
            ->where('status', 'published')
            ->firstOrFail();

        return view('landing.pages', [
            'page' => $page,
            'pageTitle' => $page->meta_title ?? $page->title,
            'pageDescription' => $page->meta_description,
            'pageKeywords' => $page->meta_keywords,
            'breadcrumb' => [
                $page->title => route('page.show', $page->slug),
            ],
        ]);
    }

    public function clearCache()
    {
        $cacheKeys = [
            'landing_page_complete_v3',
            'about_page_data_v2',
            'blog_sidebar_data_v2',
            'donations_page_data_v2',
        ];

        foreach ($cacheKeys as $key) {
            Cache::forget($key);
        }

        return back()->with('success', 'Cache berhasil dibersihkan!');
    }
}
