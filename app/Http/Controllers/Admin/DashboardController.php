<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Category;
use App\Models\User;
use App\Models\Comment;
use App\Models\Contact;
use App\Models\Donation;
use App\Models\DonationTransaction;
use App\Models\Program;
use App\Models\Announcement;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Display admin dashboard
     */
    public function index()
    {
        // Statistics
        $stats = [
            'total_posts' => Post::count(),
            'published_posts' => Post::where('status', 'published')->count(),
            'total_categories' => Category::count(),
            'total_users' => User::count(),
            'pending_comments' => Comment::where('status', 'pending')->count(),
            'new_contacts' => Contact::where('status', 'new')->count(),
            'total_donations' => Donation::sum('current_amount'),
            'pending_donations' => DonationTransaction::where('status', 'pending')->count(),
            'active_programs' => Program::where('is_active', true)->count(),
            'active_announcements' => Announcement::where('is_active', true)->count(),
        ];

        // Recent Posts
        $recentPosts = Post::with(['category', 'author'])
            ->latest()
            ->limit(5)
            ->get();

        // Popular Posts
        $popularPosts = Post::where('status', 'published')
            ->orderBy('views_count', 'desc')
            ->limit(5)
            ->get();

        // Recent Comments
        $recentComments = Comment::with(['post', 'user'])
            ->latest()
            ->limit(5)
            ->get();

        // Pending Comments
        $pendingComments = Comment::with(['post', 'user'])
            ->where('status', 'pending')
            ->latest()
            ->limit(5)
            ->get();

        // New Contacts
        $newContacts = Contact::where('status', 'new')
            ->latest()
            ->limit(5)
            ->get();

        // Recent Donation Transactions
        $recentDonations = DonationTransaction::with('donation')
            ->where('status', 'pending')
            ->latest()
            ->limit(5)
            ->get();

        // Posts Statistics (Last 7 days)
        $postsChart = $this->getPostsChartData();

        // Donation Statistics (Current month)
        $donationsChart = $this->getDonationsChartData();

        return view('admin.dashboard', compact(
            'stats',
            'recentPosts',
            'popularPosts',
            'recentComments',
            'pendingComments',
            'newContacts',
            'recentDonations',
            'postsChart',
            'donationsChart'
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

            $count = Post::whereDate('created_at', $date->toDateString())->count();
            $data[] = $count;
        }

        return [
            'labels' => $labels,
            'data' => $data,
        ];
    }

    /**
     * Get donations chart data for current month
     */
    private function getDonationsChartData()
    {
        $data = [];
        $labels = [];

        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();
        $daysInMonth = $endOfMonth->day;

        // Group by week
        for ($week = 1; $week <= 4; $week++) {
            $labels[] = 'Week ' . $week;

            $weekStart = $startOfMonth->copy()->addWeeks($week - 1);
            $weekEnd = $weekStart->copy()->addWeek();

            $total = DonationTransaction::where('status', 'verified')
                ->whereBetween('created_at', [$weekStart, $weekEnd])
                ->sum('amount');

            $data[] = $total;
        }

        return [
            'labels' => $labels,
            'data' => $data,
        ];
    }
}
