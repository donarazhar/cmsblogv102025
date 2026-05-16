<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Category;
use App\Models\Tag;
use App\Models\User;
use App\Models\Comment;
use App\Models\Contact;
use App\Models\Donation;
use App\Models\DonationTransaction;
use App\Models\Program;
use App\Models\Announcement;
use App\Models\Gallery;
use App\Models\GalleryAlbum;
use App\Models\Schedule;
use App\Models\Slider;
use App\Models\Staff;
use App\Models\Testimonial;
use Carbon\Carbon;
use Spatie\Activitylog\Models\Activity;

class DashboardController extends Controller
{
    /**
     * Display admin dashboard
     */
    public function index()
    {
        // === STATISTIK UTAMA ===
        $stats = [
            // Konten
            'total_posts'          => Post::count(),
            'published_posts'      => Post::where('status', 'published')->count(),
            'draft_posts'          => Post::where('status', 'draft')->count(),
            'total_views'          => Post::sum('views_count'),
            'total_categories'     => Category::count(),
            'total_tags'           => Tag::count(),

            // Interaksi
            'total_comments'       => Comment::count(),
            'pending_comments'     => Comment::where('status', 'pending')->count(),
            'approved_comments'    => Comment::where('status', 'approved')->count(),

            // Kontak
            'total_contacts'       => Contact::count(),
            'new_contacts'         => Contact::where('status', 'new')->count(),

            // Donasi
            'total_donation_amount'   => DonationTransaction::where('status', 'verified')->sum('amount'),
            'pending_donations'       => DonationTransaction::where('status', 'pending')->count(),
            'active_donation_programs'=> Donation::where('is_active', true)->count(),

            // Program
            'total_programs'       => Program::count(),
            'active_programs'      => Program::where('is_active', true)->count(),

            // Galeri
            'total_albums'         => GalleryAlbum::count(),
            'total_photos'         => Gallery::count(),

            // Konten Lainnya
            'active_sliders'       => Slider::where('is_active', true)->count(),
            'active_schedules'     => Schedule::where('is_active', true)->count(),
            'active_announcements' => Announcement::where('is_active', true)->count(),
            'total_staff'          => Staff::count(),
            'total_testimonials'   => Testimonial::count(),
            'total_users'          => User::count(),
        ];

        // === BERITA TERBARU ===
        $recentPosts = Post::with(['category', 'author'])
            ->latest('created_at')
            ->limit(5)
            ->get();

        // === BERITA TERPOPULER ===
        $popularPosts = Post::where('status', 'published')
            ->orderBy('views_count', 'desc')
            ->limit(5)
            ->get();

        // === KOMENTAR PENDING ===
        $pendingComments = Comment::with(['post'])
            ->where('status', 'pending')
            ->latest()
            ->limit(5)
            ->get();

        // === KONTAK BARU ===
        $newContacts = Contact::where('status', 'new')
            ->latest()
            ->limit(5)
            ->get();

        // === DONASI PENDING ===
        $recentDonations = DonationTransaction::with('donation')
            ->where('status', 'pending')
            ->latest()
            ->limit(5)
            ->get();

        // === AKTIVITAS TERBARU ===
        $recentActivities = Activity::with('causer')
            ->latest()
            ->limit(8)
            ->get();

        // === CHART: Berita per 7 hari terakhir ===
        $postsChart = $this->getPostsChartData();

        // === CHART: Donasi per minggu bulan ini ===
        $donationsChart = $this->getDonationsChartData();

        // === CHART: Komentar per 7 hari terakhir ===
        $commentsChart = $this->getCommentsChartData();

        return view('admin.dashboard', compact(
            'stats',
            'recentPosts',
            'popularPosts',
            'pendingComments',
            'newContacts',
            'recentDonations',
            'recentActivities',
            'postsChart',
            'donationsChart',
            'commentsChart'
        ));
    }

    /**
     * Get posts chart data for last 7 days
     */
    private function getPostsChartData()
    {
        $data = [];
        $labels = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $labels[] = $date->format('d M');
            $data[] = Post::whereDate('created_at', $date->toDateString())->count();
        }

        return ['labels' => $labels, 'data' => $data];
    }

    /**
     * Get donations chart data for current month
     */
    private function getDonationsChartData()
    {
        $data = [];
        $labels = [];

        $startOfMonth = Carbon::now()->startOfMonth();

        for ($week = 1; $week <= 4; $week++) {
            $labels[] = 'Minggu ' . $week;

            $weekStart = $startOfMonth->copy()->addWeeks($week - 1);
            $weekEnd = $weekStart->copy()->addWeek();

            $total = DonationTransaction::where('status', 'verified')
                ->whereBetween('created_at', [$weekStart, $weekEnd])
                ->sum('amount');

            $data[] = $total;
        }

        return ['labels' => $labels, 'data' => $data];
    }

    /**
     * Get comments chart data for last 7 days
     */
    private function getCommentsChartData()
    {
        $data = [];
        $labels = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $labels[] = $date->format('d M');
            $data[] = Comment::whereDate('created_at', $date->toDateString())->count();
        }

        return ['labels' => $labels, 'data' => $data];
    }
}
