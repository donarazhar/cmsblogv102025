<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ScheduleController extends Controller
{
    public function index(Request $request)
    {
        $query = Schedule::query();

        if ($request->has('type') && $request->type != '') {
            $query->where('type', $request->type);
        }

        if ($request->has('status') && $request->status != '') {
            $query->where('is_active', $request->status);
        }

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('location', 'like', "%{$search}%")
                    ->orWhere('imam', 'like', "%{$search}%")
                    ->orWhere('speaker', 'like', "%{$search}%");
            });
        }

        $schedules = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('admin.schedules.index', compact('schedules'));
    }

    public function create()
    {
        return view('admin.schedules.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|in:prayer,event,lecture,class,other',
            'date' => 'required_if:is_recurring,0|nullable|date',
            'day_of_week' => 'required_if:is_recurring,1|nullable|in:monday,tuesday,wednesday,thursday,friday,saturday,sunday',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'nullable|date_format:H:i|after:start_time',
            'location' => 'nullable|string|max:255',
            'imam' => 'nullable|string|max:255',
            'speaker' => 'nullable|string|max:255',
            'frequency' => 'nullable|in:daily,weekly,monthly',
            'is_recurring' => 'boolean',
            'color' => 'nullable|string|max:7',
            'is_active' => 'boolean',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $data = $request->all();
        $data['is_recurring'] = $request->has('is_recurring') ? 1 : 0;
        $data['is_active'] = $request->has('is_active') ? 1 : 0;

        if (empty($data['color'])) {
            $data['color'] = $this->getDefaultColor($data['type']);
        }

        Schedule::create($data);

        return redirect()->route('admin.schedules.index')
            ->with('success', 'Jadwal berhasil ditambahkan!');
    }

    public function show(Schedule $schedule)
    {
        return view('admin.schedules.show', compact('schedule'));
    }

    public function edit(Schedule $schedule)
    {
        return view('admin.schedules.edit', compact('schedule'));
    }

    public function update(Request $request, Schedule $schedule)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|in:prayer,event,lecture,class,other',
            'date' => 'required_if:is_recurring,0|nullable|date',
            'day_of_week' => 'required_if:is_recurring,1|nullable|in:monday,tuesday,wednesday,thursday,friday,saturday,sunday',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'nullable|date_format:H:i|after:start_time',
            'location' => 'nullable|string|max:255',
            'imam' => 'nullable|string|max:255',
            'speaker' => 'nullable|string|max:255',
            'frequency' => 'nullable|in:daily,weekly,monthly',
            'is_recurring' => 'boolean',
            'color' => 'nullable|string|max:7',
            'is_active' => 'boolean',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $data = $request->all();
        $data['is_recurring'] = $request->has('is_recurring') ? 1 : 0;
        $data['is_active'] = $request->has('is_active') ? 1 : 0;

        $schedule->update($data);

        return redirect()->route('admin.schedules.index')
            ->with('success', 'Jadwal berhasil diperbarui!');
    }

    public function destroy(Schedule $schedule)
    {
        $schedule->delete();

        return redirect()->route('admin.schedules.index')
            ->with('success', 'Jadwal berhasil dihapus!');
    }

    public function toggleActive(Schedule $schedule)
    {
        $schedule->update(['is_active' => !$schedule->is_active]);

        return redirect()->back()
            ->with('success', 'Status jadwal berhasil diubah!');
    }

    private function getDefaultColor($type)
    {
        $colors = [
            'prayer' => '#10b981',
            'event' => '#3b82f6',
            'lecture' => '#f59e0b',
            'class' => '#8b5cf6',
            'other' => '#6b7280',
        ];

        return $colors[$type] ?? '#0053C5';
    }
}
