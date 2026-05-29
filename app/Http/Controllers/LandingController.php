<?php

namespace App\Http\Controllers;

use App\Models\{
    Announcement,
    Category,
    Comment, // ✅ Tambahkan ini
    Contact,
    Donation,
    DonationTransaction,

    Page,
    Post,
    Program,

    Slider,
    Staff,
    Testimonial,
    Setting, // ✅ Tambahkan ini
    AdBanner // ✅ Tambahkan ini
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
                    ->select('id', 'title', 'subtitle', 'description', 'image', 'button_text', 'button_link', 'button_text_2', 'button_link_2', 'text_position', 'overlay_color', 'overlay_opacity', 'created_at')
                    ->limit(4)
                    ->get(),

                'announcements' => Announcement::active()
                    ->onHomepage()
                    ->byPriority()
                    ->select('id', 'title', 'content', 'type')
                    ->limit(3)
                    ->get(),

                'adBanners' => AdBanner::active()
                    ->where(function ($q) {
                        $q->whereNull('target_routes')
                          ->orWhere('target_routes', '');
                    })
                    ->ordered()
                    ->select('id', 'title', 'image', 'url_link', 'target_routes')
                    ->get(),

                'programs' => Program::active()
                    ->ordered()
                    ->select('id', 'name', 'slug', 'description', 'image', 'icon', 'frequency', 'location', 'speaker')
                    ->limit(11)
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
                    ->latest('published_at')
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

    public function profileSejarah()
    {
        return view('landing.profile.sejarah', ['title' => 'Sejarah Masjid']);
    }

    public function profileVisiMisi()
    {
        return view('landing.profile.visi-misi', ['title' => 'Visi & Misi']);
    }

    public function profileStruktur()
    {
        return view('landing.profile.struktur-organisasi', ['title' => 'Struktur Organisasi']);
    }

    public function profilePengurusStaf()
    {
        $staff = Staff::active()
            ->ordered()
            ->select('id', 'name', 'slug', 'position', 'department', 'photo')
            ->get();

        return view('landing.profile.pengurus-staf', ['title' => 'Pengurus & Staf', 'staff' => $staff]);
    }

    public function profileFasilitas()
    {
        return view('landing.profile.fasilitas', ['title' => 'Fasilitas']);
    }

    public function programs()
    {
        $programs = Program::active()
            ->ordered()
            ->select('id', 'name', 'slug', 'description', 'image', 'type', 'frequency', 'location', 'start_time')
            ->paginate(9);

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

            $pageTitle = $program->name;
            $pageDescription = \Illuminate\Support\Str::limit(strip_tags($program->description), 160);
            $pageImage = $program->image ? asset('storage/' . $program->image) : null;

            return compact('program', 'relatedPrograms', 'pageTitle', 'pageDescription', 'pageImage');
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

        $pageTitle = $post->title;
        $pageDescription = \Illuminate\Support\Str::limit(strip_tags($post->excerpt ?: $post->content), 160);
        $pageImage = $post->featured_image ? asset('storage/' . $post->featured_image) : null;

        $popularPosts = Cache::remember('popular_posts_v3', self::CACHE_LONG, function () {
            return Post::published()
                ->orderBy('views_count', 'desc')
                ->limit(4)
                ->get(['id', 'title', 'slug', 'featured_image', 'published_at']);
        });

        return view('landing.blog-detail', compact('post', 'relatedPosts', 'popularPosts', 'pageTitle', 'pageDescription', 'pageImage'));
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
            'google_verified' => 'required|in:1',
        ], [
            'name.required' => 'Nama harus diisi',
            'email.required' => 'Email harus diisi',
            'email.email' => 'Format email tidak valid',
            'comment.required' => 'Komentar harus diisi',
            'comment.max' => 'Komentar maksimal 1000 karakter',
            'google_verified.required' => 'Silakan verifikasi akun Google terlebih dahulu',
            'google_verified.in' => 'Silakan verifikasi akun Google terlebih dahulu',
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
            'google_verified' => 'required|in:1',
        ], [
            'name.required' => 'Nama harus diisi',
            'email.required' => 'Email harus diisi',
            'email.email' => 'Format email tidak valid',
            'subject.required' => 'Subjek harus diisi',
            'message.required' => 'Pesan harus diisi',
            'google_verified.required' => 'Silakan verifikasi akun Google terlebih dahulu',
            'google_verified.in' => 'Silakan verifikasi akun Google terlebih dahulu',
        ]);

        Contact::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'subject' => $validated['subject'],
            'message' => $validated['message'],
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
            ->paginate(9);

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

        $pageTitle = $donation->campaign_name;
        $pageDescription = \Illuminate\Support\Str::limit(strip_tags($donation->description), 160);
        $pageImage = $donation->image ? asset('storage/' . $donation->image) : null;

        return view('landing.donation-detail', compact('donation', 'recentDonations', 'relatedDonations', 'pageTitle', 'pageDescription', 'pageImage'));
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

    /**
     * Search across posts, programs, and donations
     * This page is required for the WebSite SearchAction schema (Google Sitelinks)
     */
    public function search(Request $request)
    {
        $query = $request->input('q', '');
        $posts = collect();
        $programs = collect();
        $donations = collect();

        if ($query) {
            $posts = Post::published()
                ->with(['category:id,name,slug', 'author:id,name'])
                ->where(function ($q) use ($query) {
                    $q->where('title', 'like', "%{$query}%")
                        ->orWhere('excerpt', 'like', "%{$query}%")
                        ->orWhere('content', 'like', "%{$query}%");
                })
                ->select('id', 'title', 'slug', 'excerpt', 'content', 'featured_image', 'published_at', 'category_id', 'author_id', 'views_count')
                ->latest('published_at')
                ->limit(10)
                ->get();

            $programs = Program::where('is_active', true)
                ->where(function ($q) use ($query) {
                    $q->where('name', 'like', "%{$query}%")
                        ->orWhere('description', 'like', "%{$query}%");
                })
                ->select('id', 'name', 'slug', 'description', 'image', 'icon', 'frequency', 'location')
                ->limit(5)
                ->get();

            $donations = Donation::where('is_active', true)
                ->where(function ($q) use ($query) {
                    $q->where('campaign_name', 'like', "%{$query}%")
                        ->orWhere('description', 'like', "%{$query}%");
                })
                ->select('id', 'campaign_name', 'slug', 'description', 'image', 'donor_count')
                ->limit(5)
                ->get();
        }

        $totalResults = $posts->count() + $programs->count() + $donations->count();

        return view('landing.search', compact('query', 'posts', 'programs', 'donations', 'totalResults'));
    }

    public function clearCache()
    {
        Cache::flush(); // Clear all cache
        return back()->with('success', 'Cache berhasil dibersihkan!');
    }
}
