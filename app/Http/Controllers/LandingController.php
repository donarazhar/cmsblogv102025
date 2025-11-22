<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\Category;
use App\Models\Donation;
use App\Models\Gallery;
use App\Models\GalleryAlbum;
use App\Models\Post;
use App\Models\Program;
use App\Models\Schedule;
use App\Models\Setting;
use App\Models\Slider;
use App\Models\Staff;
use App\Models\Testimonial;
use App\Models\DonationTransaction;
use Illuminate\Http\Request;

class LandingController extends Controller
{
    /**
     * Display landing page
     */
    public function index()
    {
        // Hero Sliders - limit dan select specific columns
        $sliders = Slider::active()
            ->ordered()
            ->select('id', 'title', 'subtitle', 'description', 'image', 'button_text', 'button_link', 'button_text_2', 'button_link_2', 'text_position', 'overlay_color', 'overlay_opacity')
            ->limit(5)
            ->get();

        // Latest Posts - dengan eager loading
        $latestPosts = Post::published()
            ->with(['category:id,name,slug', 'author:id,name', 'tags:id,name,slug'])
            ->latest('published_at')
            ->limit(3)
            ->get();

        // Featured Posts
        $featuredPosts = Post::published()
            ->featured()
            ->with(['category:id,name,slug', 'author:id,name'])
            ->limit(3)
            ->get();

        // Categories
        $categories = Category::active()
            ->withCount(['posts' => function ($query) {
                $query->where('status', 'published');
            }])
            ->ordered()
            ->limit(3)
            ->get();

        // Active Programs
        $programs = Program::active()
            ->featured()
            ->ordered()
            ->select('id', 'name', 'slug', 'description', 'image', 'icon', 'type', 'frequency', 'location', 'start_time')
            ->limit(4)
            ->get();

        // Gallery - Featured Images
        $galleries = Gallery::active()
            ->featured()
            ->images()
            ->ordered()
            ->select('id', 'title', 'description', 'image')
            ->limit(6)
            ->get();

        // Gallery Albums
        $albums = GalleryAlbum::active()
            ->withCount('galleries')
            ->latest('event_date')
            ->select('id', 'name', 'slug', 'cover_image', 'event_date')
            ->limit(3)
            ->get();

        // Today's Schedule
        $todaySchedules = Schedule::active()
            ->today()
            ->orderBy('start_time', 'asc')
            ->select('id', 'title', 'type', 'start_time', 'end_time', 'location', 'imam', 'speaker', 'color')
            ->limit(3)
            ->get();

        // Upcoming Events
        $upcomingEvents = Schedule::active()
            ->where('type', 'event')
            ->upcoming(30)
            ->select('id', 'title', 'date', 'start_time', 'end_time', 'location')
            ->limit(3)
            ->get();

        // Active Announcements
        $announcements = Announcement::active()
            ->onHomepage()
            ->byPriority()
            ->ordered()
            ->select('id', 'title', 'content', 'type', 'priority')
            ->limit(3)
            ->get();

        // Featured Staff
        $staff = Staff::active()
            ->featured()
            ->ordered()
            ->select('id', 'name', 'position', 'photo', 'slug')
            ->limit(3)
            ->get();

        // Testimonials
        $testimonials = Testimonial::approved()
            ->featured()
            ->ordered()
            ->select('id', 'name', 'role', 'company', 'content', 'photo', 'rating')
            ->limit(6)
            ->get();

        // Active Donations
        $donations = Donation::active()
            ->ongoing()
            ->featured()
            ->ordered()
            ->select('id', 'campaign_name', 'slug', 'description', 'image', 'category', 'target_amount', 'current_amount', 'donor_count', 'end_date')
            ->limit(3)
            ->get();

        // Statistics - use cache
        $stats = cache()->remember('landing_stats', 3600, function () {
            return [
                'total_posts' => Post::published()->count(),
                'total_programs' => Program::active()->count(),
                'total_donations' => Donation::active()->sum('current_amount'),
                'total_testimonials' => Testimonial::approved()->count(),
            ];
        });

        // Settings - use cache
        $settings = cache()->remember('settings_all', 3600, function () {
            return Setting::pluck('value', 'key')->toArray();
        });

        return view('landing.index', compact(
            'sliders',
            'latestPosts',
            'featuredPosts',
            'categories',
            'programs',
            'galleries',
            'albums',
            'todaySchedules',
            'upcomingEvents',
            'announcements',
            'staff',
            'testimonials',
            'donations',
            'stats',
            'settings'
        ));
    }

    /**
     * Show about page
     */
    public function about()
    {
        $staff = Staff::active()->ordered()->get();
        $settings = Setting::getAll();

        return view('landing.about', compact('staff', 'settings'));
    }

    /**
     * Show programs page
     */
    public function programs()
    {
        $programs = Program::active()->ordered()->paginate(12);
        $settings = Setting::getAll();

        return view('landing.programs', compact('programs', 'settings'));
    }

    /**
     * Show single program
     */
    public function programDetail($slug)
    {
        $program = Program::where('slug', $slug)->where('is_active', true)->firstOrFail();
        $relatedPrograms = Program::active()
            ->where('id', '!=', $program->id)
            ->where('type', $program->type)
            ->limit(3)
            ->get();

        $settings = Setting::getAll();

        return view('landing.program-detail', compact('program', 'relatedPrograms', 'settings'));
    }

    /**
     * Show blog/news page
     */
    public function blog(Request $request)
    {
        $query = Post::published()->with(['category', 'author', 'tags']);

        // Filter by category
        if ($request->has('category')) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        // Filter by tag
        if ($request->has('tag')) {
            $query->whereHas('tags', function ($q) use ($request) {
                $q->where('slug', $request->tag);
            });
        }

        // Search
        if ($request->has('search')) {
            $query->search($request->search);
        }

        $posts = $query->latest('published_at')->paginate(6);
        $categories = Category::active()->withCount('posts')->ordered()->get();
        $popularPosts = Post::published()->popular(5)->get();
        $settings = Setting::getAll();

        return view('landing.blog', compact('posts', 'categories', 'popularPosts', 'settings'));
    }

    /**
     * Show single blog post
     */
    public function blogDetail($slug)
    {
        $post = Post::where('slug', $slug)
            ->where('status', 'published')
            ->with(['category', 'author', 'tags', 'approvedComments.user'])
            ->firstOrFail();

        // Increment views
        $post->incrementViews();

        // Related posts
        $relatedPosts = Post::published()
            ->where('id', '!=', $post->id)
            ->where('category_id', $post->category_id)
            ->limit(3)
            ->get();

        $settings = Setting::getAll();

        return view('landing.blog-detail', compact('post', 'relatedPosts', 'settings'));
    }

    /**
     * Show gallery page
     */
    public function gallery()
    {
        $albums = GalleryAlbum::active()
            ->withCount('galleries')
            ->latest('event_date')
            ->paginate(12);

        $settings = Setting::getAll();

        return view('landing.gallery', compact('albums', 'settings'));
    }

    /**
     * Show gallery album
     */
    public function galleryAlbum($slug)
    {
        $album = GalleryAlbum::where('slug', $slug)->where('is_active', true)->firstOrFail();
        $galleries = Gallery::where('album_id', $album->id)
            ->where('is_active', true)
            ->ordered()
            ->get();

        $settings = Setting::getAll();

        return view('landing.gallery-album', compact('album', 'galleries', 'settings'));
    }

    /**
     * Show contact page
     */
    public function contact()
    {
        $settings = Setting::getAll();

        return view('landing.contact', compact('settings'));
    }

    /**
     * Handle contact form submission
     */
    public function contactSubmit(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ], [
            'name.required' => 'Nama harus diisi',
            'email.required' => 'Email harus diisi',
            'email.email' => 'Format email tidak valid',
            'subject.required' => 'Subjek harus diisi',
            'message.required' => 'Pesan harus diisi',
        ]);

        \App\Models\Contact::create([
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

    /**
     * Show donations page
     */
    public function donations()
    {
        $donations = Donation::active()
            ->ongoing()
            ->ordered()
            ->paginate(12);

        $featuredDonations = Donation::active()
            ->featured()
            ->ongoing()
            ->ordered()
            ->limit(3)
            ->get();

        // Statistics
        $stats = [
            'total_collected' => Donation::sum('current_amount'),
            'total_donors' => DonationTransaction::where('status', 'verified')->count(),
            'active_campaigns' => Donation::active()->ongoing()->count(),
        ];

        $settings = Setting::getAll();

        return view('landing.donations', compact('donations', 'featuredDonations', 'stats', 'settings'));
    }

    /**
     * Show single donation campaign
     */
    public function donationDetail($slug)
    {
        $donation = Donation::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        // Recent Transactions
        $recentDonations = DonationTransaction::where('donation_id', $donation->id)
            ->where('status', 'verified')
            ->where('is_anonymous', false)
            ->latest()
            ->limit(10)
            ->get();

        // Related Donations
        $relatedDonations = Donation::active()
            ->ongoing()
            ->where('id', '!=', $donation->id)
            ->where('category', $donation->category)
            ->limit(3)
            ->get();

        $settings = Setting::getAll();

        return view('landing.donation-detail', compact('donation', 'recentDonations', 'relatedDonations', 'settings'));
    }
}
