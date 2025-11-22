<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Staff;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

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

        // Filter by featured
        if ($request->filled('featured')) {
            $query->where('is_featured', $request->featured === 'yes');
        }

        // Sort
        $sortField = $request->get('sort', 'order');
        $sortDirection = $request->get('direction', 'asc');
        $query->orderBy($sortField, $sortDirection);

        $staff = $query->paginate(5)->withQueryString();

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
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'specialization' => 'nullable|string|max:255',
            'join_date' => 'nullable|date',
            'order' => 'nullable|integer|min:0',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
            // Social media
            'facebook' => 'nullable|url',
            'twitter' => 'nullable|url',
            'instagram' => 'nullable|url',
            'linkedin' => 'nullable|url',
            'youtube' => 'nullable|url',
        ]);

        // Generate slug if not provided
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        } else {
            $validated['slug'] = Str::slug($validated['slug']);
        }

        // Handle photo upload
        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('staff', 'public');
        }

        // Handle social media
        $validated['social_media'] = [
            'facebook' => $request->facebook,
            'twitter' => $request->twitter,
            'instagram' => $request->instagram,
            'linkedin' => $request->linkedin,
            'youtube' => $request->youtube,
        ];

        $validated['is_featured'] = $request->has('is_featured');
        $validated['is_active'] = $request->has('is_active');

        Staff::create($validated);

        return redirect()->route('admin.staff.index')
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
            'slug' => ['nullable', 'string', 'max:255', Rule::unique('staff')->ignore($staff->id)],
            'position' => 'required|string|max:255',
            'department' => 'nullable|string|max:255',
            'type' => 'required|in:board,imam,teacher,staff,volunteer',
            'biography' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'specialization' => 'nullable|string|max:255',
            'join_date' => 'nullable|date',
            'order' => 'nullable|integer|min:0',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
            // Social media
            'facebook' => 'nullable|url',
            'twitter' => 'nullable|url',
            'instagram' => 'nullable|url',
            'linkedin' => 'nullable|url',
            'youtube' => 'nullable|url',
        ]);

        // Generate slug if not provided
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        } else {
            $validated['slug'] = Str::slug($validated['slug']);
        }

        // Handle photo upload
        if ($request->hasFile('photo')) {
            // Delete old photo
            if ($staff->photo) {
                Storage::disk('public')->delete($staff->photo);
            }
            $validated['photo'] = $request->file('photo')->store('staff', 'public');
        }

        // Handle social media
        $validated['social_media'] = [
            'facebook' => $request->facebook,
            'twitter' => $request->twitter,
            'instagram' => $request->instagram,
            'linkedin' => $request->linkedin,
            'youtube' => $request->youtube,
        ];

        $validated['is_featured'] = $request->has('is_featured');
        $validated['is_active'] = $request->has('is_active');

        $staff->update($validated);

        return redirect()->route('admin.staff.index')
            ->with('success', 'Staff berhasil diperbarui!');
    }

    public function removePhoto(Staff $staff)
    {
        if ($staff->photo && Storage::disk('public')->exists($staff->photo)) {
            Storage::disk('public')->delete($staff->photo);
            $staff->update(['photo' => null]);
        }

        return redirect()->back()->with('success', 'Foto berhasil dihapus!');
    }

    public function destroy(Staff $staff)
    {
        // Delete photo
        if ($staff->photo) {
            Storage::disk('public')->delete($staff->photo);
        }

        $staff->delete();

        return redirect()->route('admin.staff.index')
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
            if ($member->photo) {
                Storage::disk('public')->delete($member->photo);
            }
            $member->delete();
        }

        return redirect()->route('admin.staff.index')
            ->with('success', count($request->ids) . ' staff berhasil dihapus!');
    }

    public function updateOrder(Request $request)
    {
        $request->validate([
            'orders' => 'required|array',
            'orders.*' => 'required|integer',
        ]);

        foreach ($request->orders as $id => $order) {
            Staff::where('id', $id)->update(['order' => $order]);
        }

        return response()->json(['success' => true, 'message' => 'Urutan berhasil diperbarui']);
    }
}
