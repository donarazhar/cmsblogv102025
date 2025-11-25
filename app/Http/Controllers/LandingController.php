<?php

namespace App\Http\Controllers;

use App\Models\{
    Announcement,
    Category,
    Comment, // ✅ Tambahkan ini
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
use Illuminate\Support\Facades\DB;

class LandingController extends Controller
{
    /**
     * Cache duration constants
     */
    private const CACHE_SHORT = 60;   // ✅ 1 minute (was 3 minutes)
    private const CACHE_MEDIUM = 300; // ✅ 5 minutes (was 10 minutes)
    private const CACHE_LONG = 600;   // ✅ 10 minutes (was 30 minutes)

    public function index()
    {
        // Eager load dengan chunk untuk performa optimal
        $data = Cache::remember('landing_page_v4', self::CACHE_SHORT, function () {
            return [
                'sliders' => Slider::active()
                    ->ordered()
                    ->select('id', 'title', 'subtitle', 'image', 'button_text', 'button_link', 'text_position')
                    ->limit(4) // Kurangi dari 5 ke 3 untuk loading lebih cepat
                    ->get(),

                'announcements' => Announcement::active()
                    ->onHomepage()
                    ->byPriority()
                    ->select('id', 'title', 'type')
                    ->limit(3)
                    ->get(),

                'programs' => Program::active()
                    ->featured()
                    ->ordered()
                    ->select('id', 'name', 'slug', 'description', 'image', 'icon', 'frequency', 'location')
                    ->limit(6)
                    ->get(),

                'latestPosts' => Post::published()
                    ->with(['category:id,name,slug', 'author:id,name'])
                    ->select('id', 'title', 'slug', 'excerpt', 'featured_image', 'published_at', 'category_id', 'author_id', 'views_count')
                    ->latest('published_at')
                    ->limit(8)
                    ->get(),

                'featuredPosts' => Post::published()
                    ->featured()
                    ->with(['category:id,name,slug', 'author:id,name'])
                    ->select('id', 'title', 'slug', 'excerpt', 'featured_image', 'published_at', 'category_id', 'author_id')
                    ->limit(3) // Kurangi dari 3 ke 2
                    ->get(),

                'galleries' => Gallery::active()
                    ->featured()
                    ->images()
                    ->ordered()
                    ->select('id', 'title', 'image')
                    ->limit(6)
                    ->get(),

                'albums' => GalleryAlbum::active()
                    ->withCount('galleries')
                    ->latest('event_date')
                    ->select('id', 'name', 'slug', 'cover_image', 'event_date')
                    ->limit(3)
                    ->get(),

                'todaySchedules' => Schedule::active()
                    ->today()
                    ->orderBy('start_time')
                    ->select('id', 'title', 'type', 'start_time', 'end_time', 'location', 'speaker', 'color')
                    ->limit(6)
                    ->get(),

                'upcomingEvents' => Schedule::active()
                    ->where('type', 'event')
                    ->upcoming(14) // 2 minggu ke depan saja
                    ->select('id', 'title', 'date', 'start_time', 'location')
                    ->limit(3)
                    ->get(),

                'testimonials' => Testimonial::approved()
                    ->featured()
                    ->ordered()
                    ->select('id', 'name', 'role', 'content', 'photo', 'rating')
                    ->limit(4) // Kurangi dari 6 ke 4
                    ->get(),

                'donations' => Donation::active()
                    ->ongoing()
                    ->featured()
                    ->ordered()
                    ->select('id', 'campaign_name', 'slug', 'description', 'image', 'target_amount', 'current_amount', 'donor_count', 'end_date')
                    ->limit(3)
                    ->get(),
            ];
        });

        return view('landing.index', $data);
    }

    public function about()
    {
        $data = Cache::remember('about_page_v3', self::CACHE_MEDIUM, function () {
            return [
                'staff' => Staff::active()
                    ->ordered()
                    ->select('id', 'name', 'slug', 'position', 'department', 'photo')
                    ->get(),
            ];
        });

        return view('landing.about', $data);
    }

    public function programs()
    {
        $programs = Program::active()
            ->ordered()
            ->select('id', 'name', 'slug', 'description', 'image', 'type', 'frequency', 'location', 'start_time')
            ->paginate(12);

        return view('landing.programs', compact('programs'));
    }

    public function programDetail(string $slug)
    {
        $cacheKey = "program_{$slug}_v3";

        $data = Cache::remember($cacheKey, self::CACHE_MEDIUM, function () use ($slug) {
            $program = Program::where('slug', $slug)
                ->where('is_active', true)
                ->firstOrFail();

            $relatedPrograms = Program::active()
                ->where('id', '!=', $program->id)
                ->where('type', $program->type)
                ->select('id', 'name', 'slug', 'image', 'icon')
                ->limit(3)
                ->get();

            return compact('program', 'relatedPrograms');
        });

        return view('landing.program-detail', $data);
    }

    public function blog(Request $request)
    {
        $query = Post::published()
            ->with(['category:id,name,slug', 'author:id,name'])
            ->select('id', 'title', 'slug', 'excerpt', 'featured_image', 'published_at', 'category_id', 'author_id', 'views_count');

        // Filter by category
        if ($request->filled('category')) {
            $query->whereHas('category', fn($q) => $q->where('slug', $request->category));
        }

        // Filter by tag
        if ($request->filled('tag')) {
            $query->whereHas('tags', fn($q) => $q->where('slug', $request->tag));
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(
                fn($q) => $q
                    ->where('title', 'like', "%{$search}%")
                    ->orWhere('excerpt', 'like', "%{$search}%")
            );
        }

        $posts = $query->latest('published_at')->paginate(9);

        $sidebarData = Cache::remember('blog_sidebar_v3', self::CACHE_SHORT, function () {
            return [
                'categories' => Category::active()
                    ->withCount(['posts' => fn($q) => $q->where('status', 'published')])
                    ->ordered()
                    ->select('id', 'name', 'slug')
                    ->get(),

                'popularPosts' => Post::published()
                    ->orderByDesc('views_count')
                    ->select('id', 'title', 'slug', 'featured_image', 'published_at')
                    ->limit(5)
                    ->get(),
            ];
        });

        return view('landing.blog', array_merge(compact('posts'), $sidebarData));
    }

    public function blogDetail(string $slug)
    {
        $post = Post::where('slug', $slug)
            ->where('status', 'published')
            ->with([
                'category:id,name,slug',
                'author:id,name',
                'tags:id,name,slug',
                'approvedComments.replies.user:id,name',
                'approvedComments.user:id,name'
            ])
            ->firstOrFail();

        // Increment views async
        dispatch(fn() => $post->increment('views_count'))->afterResponse();

        $relatedPosts = Cache::remember("related_{$post->category_id}_v3", self::CACHE_SHORT, function () use ($post) {
            return Post::published()
                ->where('id', '!=', $post->id)
                ->where('category_id', $post->category_id)
                ->with(['category:id,name,slug', 'author:id,name'])
                ->select('id', 'title', 'slug', 'excerpt', 'featured_image', 'published_at', 'category_id', 'author_id')
                ->limit(3)
                ->get();
        });

        return view('landing.blog-detail', compact('post', 'relatedPosts'));
    }

    public function blogCommentSubmit(Request $request, string $slug)
    {
        $post = Post::where('slug', $slug)
            ->where('status', 'published')
            ->firstOrFail();

        // Validate input
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'comment' => 'required|string|max:1000',
        ], [
            'name.required' => 'Nama harus diisi',
            'email.required' => 'Email harus diisi',
            'email.email' => 'Format email tidak valid',
            'comment.required' => 'Komentar harus diisi',
            'comment.max' => 'Komentar maksimal 1000 karakter',
        ]);

        // ✅ FIX: Map to correct field names
        Comment::create([
            'post_id' => $post->id,
            'author_name' => $validated['name'],  // ✅ Changed from 'author'
            'author_email' => $validated['email'], // ✅ Changed from 'email'
            'content' => $validated['comment'],
            'status' => 'pending',
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return redirect()
            ->route('blog.detail', $slug)
            ->with('success', 'Terima kasih! Komentar Anda telah dikirim dan menunggu persetujuan admin.');
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

    public function galleryAlbum(string $slug)
    {
        $data = Cache::remember("album_{$slug}_v3", self::CACHE_MEDIUM, function () use ($slug) {
            $album = GalleryAlbum::where('slug', $slug)
                ->where('is_active', true)
                ->firstOrFail();

            $galleries = Gallery::where('album_id', $album->id)
                ->where('is_active', true)
                ->ordered()
                ->select('id', 'title', 'image', 'type')
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
        $validated = $request->validate([
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
            ...$validated,
            'status' => 'new',
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return back()->with('success', 'Terima kasih! Pesan Anda telah terkirim.');
    }

    public function donations()
    {
        $donations = Donation::active()
            ->ongoing()
            ->ordered()
            ->select('id', 'campaign_name', 'slug', 'description', 'image', 'category', 'target_amount', 'current_amount', 'donor_count', 'end_date')
            ->paginate(12);

        $cachedData = Cache::remember('donations_stats_v3', self::CACHE_SHORT, function () {
            return [
                'featuredDonations' => Donation::active()
                    ->featured()
                    ->ongoing()
                    ->select('id', 'campaign_name', 'slug', 'image', 'target_amount', 'current_amount')
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

    public function donationDetail(string $slug)
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

        $relatedDonations = Cache::remember("donation_related_{$donation->category}_v3", self::CACHE_SHORT, function () use ($donation) {
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

    public function page(string $slug)
    {
        $page = Cache::remember("page_{$slug}_v3", self::CACHE_LONG, function () use ($slug) {
            return Page::where('slug', $slug)
                ->where('status', 'published')
                ->firstOrFail();
        });

        return view('landing.pages', [
            'page' => $page,
            'pageTitle' => $page->meta_title ?? $page->title,
            'pageDescription' => $page->meta_description,
        ]);
    }

    public function clearCache()
    {
        Cache::flush(); // Clear all cache
        return back()->with('success', 'Cache berhasil dibersihkan!');
    }
}
