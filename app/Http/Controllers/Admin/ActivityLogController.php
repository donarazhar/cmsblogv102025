<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ActivityLogController extends Controller
{
    public function index(Request $request)
    {
        $query = Activity::where('log_name', 'frontend')->with('causer');

        // Filter by user
        if ($request->filled('user')) {
            $query->where('causer_id', $request->user);
        }

        // Filter by page type
        if ($request->filled('page_type')) {
            $query->where('properties->page_type', $request->page_type);
        }

        // Filter by date range
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('description', 'like', "%{$search}%")
                    ->orWhere('properties->path', 'like', "%{$search}%")
                    ->orWhere('properties->url', 'like', "%{$search}%")
                    ->orWhere('properties->ip', 'like', "%{$search}%");
            });
        }

        $activities = $query->latest()->paginate(50)->withQueryString();

        // Get users who have activities (for filter)
        $users = User::whereHas('actions', function ($q) {
            $q->where('log_name', 'frontend');
        })->orderBy('name')->get();

        // Statistics
        $stats = $this->getFrontendStatistics($request);

        return view('admin.activity-logs.index', compact('activities', 'stats', 'users'));
    }

    public function analytics(Request $request)
    {
        // Set timezone ke Asia/Jakarta
        Carbon::setLocale('id');
        $timezone = 'Asia/Jakarta';
        
        $period = $request->get('period', 'today');

        $stats = [
            'total_activities' => $this->getTotalPageViews($period),
            'active_users' => $this->getUniqueVisitors($period),
            'popular_pages' => $this->getPopularPages($period),
            'user_sessions' => $this->getUserSessions($period),
            'average_session_duration' => $this->getAverageSessionDuration($period),
            'hourly_activity' => $this->getHourlyActivity($period),
            'daily_activity' => $this->getDailyActivity($period),
            'peak_hours' => $this->getPeakHours($period),
            'device_stats' => $this->getDeviceStats($period),
            'browser_stats' => $this->getBrowserStats($period),
        ];

        return view('admin.activity-logs.analytics', compact('stats', 'period'));
    }

    public function show(Activity $activity)
    {
        $activity->load('causer');

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $activity->id,
                'description' => $activity->description,
                'log_name' => $activity->log_name,
                'causer' => [
                    'id' => $activity->causer?->id,
                    'name' => $activity->causer?->name ?? 'Guest',
                    'email' => $activity->causer?->email ?? '-',
                ],
                'properties' => $activity->properties,
                'created_at' => $activity->created_at->format('d F Y, H:i:s'),
                'created_at_human' => $activity->created_at->diffForHumans(),
            ]
        ]);
    }

    public function destroy(Activity $activity)
    {
        $activity->delete();

        return redirect()->back()
            ->with('success', 'Log aktivitas berhasil dihapus!');
    }

    public function clear(Request $request)
    {
        $request->validate([
            'period' => 'required|in:all,month,week',
        ]);

        $query = Activity::where('log_name', 'frontend');

        switch ($request->period) {
            case 'week':
                $query->where('created_at', '<', now()->subWeek())->delete();
                $message = 'Log aktivitas lebih dari 1 minggu berhasil dihapus!';
                break;
            case 'month':
                $query->where('created_at', '<', now()->subMonth())->delete();
                $message = 'Log aktivitas lebih dari 1 bulan berhasil dihapus!';
                break;
            case 'all':
                $query->delete();
                $message = 'Semua log aktivitas berhasil dihapus!';
                break;
        }

        return redirect()->back()
            ->with('success', $message);
    }

    // Private helper methods
    private function getFrontendStatistics($request)
    {
        $query = Activity::where('log_name', 'frontend');

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        return [
            'total' => $query->count(),
            'today' => Activity::where('log_name', 'frontend')
                ->whereDate('created_at', today())
                ->count(),
            'this_week' => Activity::where('log_name', 'frontend')
                ->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])
                ->count(),
            'this_month' => Activity::where('log_name', 'frontend')
                ->whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->count(),
            'unique_visitors' => $query->distinct('properties->ip')->count('properties->ip'),
        ];
    }

    private function getTotalPageViews($period)
    {
        return $this->getPeriodQuery($period)->count();
    }

    private function getUniqueVisitors($period)
    {
        return $this->getPeriodQuery($period)
            ->distinct('properties->ip')
            ->count('properties->ip');
    }

    private function getPopularPages($period)
    {
        $activities = $this->getPeriodQuery($period)
            ->select('properties->route as route')
            ->get()
            ->groupBy('route')
            ->map(function ($group) {
                return [
                    'route' => $group->first()->route ?? 'N/A',
                    'visits' => $group->count(),
                ];
            })
            ->sortByDesc('visits')
            ->take(10)
            ->values();

        return $activities;
    }

    private function getUserSessions($period)
    {
        return $this->getPeriodQuery($period)
            ->distinct('properties->session_id')
            ->count('properties->session_id');
    }

    private function getAverageSessionDuration($period)
    {
        $sessions = $this->getPeriodQuery($period)
            ->select('properties->session_id as session_id', DB::raw('MIN(created_at) as start_time'), DB::raw('MAX(created_at) as end_time'))
            ->groupBy('properties->session_id')
            ->get();

        if ($sessions->isEmpty()) {
            return 0;
        }

        $totalDuration = $sessions->sum(function ($session) {
            return Carbon::parse($session->end_time)->diffInMinutes(Carbon::parse($session->start_time));
        });

        return round($totalDuration / $sessions->count(), 2);
    }

    private function getHourlyActivity($period)
    {
        $activities = $this->getPeriodQuery($period)
            ->select(DB::raw('HOUR(created_at) as hour'), DB::raw('COUNT(*) as count'))
            ->groupBy('hour')
            ->orderBy('hour')
            ->pluck('count', 'hour')
            ->toArray();

        // Fill missing hours with 0
        $result = [];
        for ($i = 0; $i < 24; $i++) {
            $result[$i] = $activities[$i] ?? 0;
        }

        return $result;
    }

    private function getDailyActivity($period)
    {
        if ($period === 'today') {
            return $this->getHourlyActivity($period);
        }

        $activities = $this->getPeriodQuery($period)
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('COUNT(*) as count'))
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('count', 'date')
            ->toArray();

        return $activities;
    }

    private function getPeakHours($period)
    {
        $hourlyActivity = $this->getHourlyActivity($period);

        if (empty($hourlyActivity)) {
            return [];
        }

        arsort($hourlyActivity);

        return array_slice($hourlyActivity, 0, 3, true);
    }

    private function getDeviceStats($period)
    {
        $activities = $this->getPeriodQuery($period)
            ->select('properties->device_type as device_type')
            ->get()
            ->groupBy('device_type')
            ->map(fn($group) => $group->count())
            ->toArray();

        return $activities ?: ['Desktop' => 0, 'Mobile' => 0, 'Tablet' => 0];
    }

    private function getBrowserStats($period)
    {
        $activities = $this->getPeriodQuery($period)
            ->select('properties->browser as browser')
            ->get()
            ->groupBy('browser')
            ->map(fn($group) => $group->count())
            ->sortDesc()
            ->toArray();

        return $activities ?: [];
    }

    private function getPeriodQuery($period)
    {
        $query = Activity::where('log_name', 'frontend');

        switch ($period) {
            case 'today':
                $query->whereDate('created_at', today());
                break;
            case 'week':
                $query->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
                break;
            case 'month':
                $query->whereMonth('created_at', now()->month)
                    ->whereYear('created_at', now()->year);
                break;
            case 'year':
                $query->whereYear('created_at', now()->year);
                break;
        }

        return $query;
    }
}
