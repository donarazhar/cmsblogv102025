<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Staff;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class StaffController extends Controller
{
    public function index(Request $request)
    {
        $query = Staff::query();

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('position', 'like', "%{$search}%")
                    ->orWhere('department', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Filter by type
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('is_active', $request->status === 'active');
        }

        // Sort
        $sortField = $request->get('sort', 'order');
        $sortDirection = $request->get('direction', 'asc');
        $query->orderBy($sortField, $sortDirection);

        $staff = $query->paginate(12)->withQueryString();

        // Stats
        $stats = [
            'total' => Staff::count(),
            'active' => Staff::active()->count(),
            'featured' => Staff::featured()->count(),
            'by_type' => [
                'board' => Staff::byType('board')->count(),
                'imam' => Staff::byType('imam')->count(),
                'teacher' => Staff::byType('teacher')->count(),
                'staff' => Staff::byType('staff')->count(),
                'volunteer' => Staff::byType('volunteer')->count(),
            ]
        ];

        return view('admin.staff.index', compact('staff', 'stats'));
    }

    public function create()
    {
        return view('admin.staff.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:staff,slug',
            'position' => 'required|string|max:255',
            'department' => 'nullable|string|max:255',
            'type' => 'required|in:board,imam,teacher,staff,volunteer',
            'biography' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'specialization' => 'nullable|string|max:255',
            'facebook' => 'nullable|url',
            'instagram' => 'nullable|url',
            'twitter' => 'nullable|url',
            'linkedin' => 'nullable|url',
            'join_date' => 'nullable|date',
            'order' => 'nullable|integer|min:0',
        ]);

        // ❌ HAPUS BARIS INI - Ini yang bikin stuck!
        // dd($validated);

        // Handle photo upload
        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('staff/photos', 'public');
        }

        // Combine social media fields ke JSON
        $validated['social_media'] = array_filter([
            'facebook' => $request->facebook,
            'instagram' => $request->instagram,
            'twitter' => $request->twitter,
            'linkedin' => $request->linkedin,
        ]);

        // Remove individual social media fields
        unset($validated['facebook'], $validated['instagram'], $validated['twitter'], $validated['linkedin']);

        // Handle checkboxes
        $validated['is_featured'] = $request->has('is_featured') ? 1 : 0;
        $validated['is_active'] = $request->has('is_active') ? 1 : 0;

        // Auto-generate slug if empty
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);

            // Check for duplicate slug
            $count = Staff::where('slug', 'LIKE', $validated['slug'] . '%')->count();
            if ($count > 0) {
                $validated['slug'] = $validated['slug'] . '-' . ($count + 1);
            }
        }

        // Auto increment order if not set
        if (!isset($validated['order'])) {
            $maxOrder = Staff::max('order') ?? 0;
            $validated['order'] = $maxOrder + 1;
        }

        Staff::create($validated);

        return redirect()
            ->route('admin.staff.index')
            ->with('success', 'Staff berhasil ditambahkan!');
    }

    public function show(Staff $staff)
    {
        return view('admin.staff.show', compact('staff'));
    }

    public function edit(Staff $staff)
    {
        return view('admin.staff.edit', compact('staff'));
    }

    public function update(Request $request, Staff $staff)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:staff,slug,' . $staff->id,
            'position' => 'required|string|max:255',
            'department' => 'nullable|string|max:255',
            'type' => 'required|in:board,imam,teacher,staff,volunteer',
            'biography' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'specialization' => 'nullable|string|max:255',
            'facebook' => 'nullable|url',
            'instagram' => 'nullable|url',
            'twitter' => 'nullable|url',
            'linkedin' => 'nullable|url',
            'join_date' => 'nullable|date',
            'order' => 'nullable|integer|min:0',
        ]);

        // Handle photo upload
        if ($request->hasFile('photo')) {
            // Delete old photo
            if ($staff->photo && Storage::disk('public')->exists($staff->photo)) {
                Storage::disk('public')->delete($staff->photo);
            }
            $validated['photo'] = $request->file('photo')->store('staff/photos', 'public');
        }

        // Combine social media fields ke JSON
        $validated['social_media'] = array_filter([
            'facebook' => $request->facebook,
            'instagram' => $request->instagram,
            'twitter' => $request->twitter,
            'linkedin' => $request->linkedin,
        ]);

        // Remove individual social media fields
        unset($validated['facebook'], $validated['instagram'], $validated['twitter'], $validated['linkedin']);

        // Handle checkboxes
        $validated['is_featured'] = $request->has('is_featured') ? 1 : 0;
        $validated['is_active'] = $request->has('is_active') ? 1 : 0;

        // Auto-generate slug if empty
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        $staff->update($validated);

        return redirect()
            ->route('admin.staff.index')
            ->with('success', 'Staff berhasil diupdate!');
    }

    public function removePhoto(Staff $staff)
    {
        if ($staff->photo && Storage::disk('public')->exists($staff->photo)) {
            Storage::disk('public')->delete($staff->photo);
            $staff->update(['photo' => null]);
        }

        return redirect()
            ->route('admin.staff.edit', $staff)
            ->with('success', 'Foto berhasil dihapus!');
    }

    public function destroy(Staff $staff)
    {
        // Delete photo
        if ($staff->photo && Storage::disk('public')->exists($staff->photo)) {
            Storage::disk('public')->delete($staff->photo);
        }

        $staff->delete();

        return redirect()
            ->route('admin.staff.index')
            ->with('success', 'Staff berhasil dihapus!');
    }

    public function bulkDelete(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:staff,id',
        ]);

        $staff = Staff::whereIn('id', $request->ids)->get();

        foreach ($staff as $member) {
            if ($member->photo && Storage::disk('public')->exists($member->photo)) {
                Storage::disk('public')->delete($member->photo);
            }
            $member->delete();
        }

        return redirect()
            ->route('admin.staff.index')
            ->with('success', count($request->ids) . ' staff berhasil dihapus!');
    }
}
