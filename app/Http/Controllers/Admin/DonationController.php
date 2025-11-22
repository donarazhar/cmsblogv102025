<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Donation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DonationController extends Controller
{
    public function index()
    {
        $donations = Donation::withCount('transactions')
            ->with('verifiedTransactions')
            ->latest()
            ->paginate(10);

        return view('admin.donations.index', compact('donations'));
    }

    public function create()
    {
        return view('admin.donations.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'campaign_name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:donations,slug',
            'description' => 'required|string',
            'content' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'category' => 'required|in:infaq,sedekah,zakat,wakaf,qurban,renovation,program,other',
            'target_amount' => 'nullable|numeric|min:0',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'is_urgent' => 'boolean',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
            'order' => 'nullable|integer|min:0',
            'payment_methods' => 'nullable|array',
        ]);

        // Generate slug if not provided
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['campaign_name']);
        }

        // Handle image upload
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('donations', 'public');
        }

        // Handle checkboxes
        $validated['is_urgent'] = $request->has('is_urgent');
        $validated['is_featured'] = $request->has('is_featured');
        $validated['is_active'] = $request->has('is_active');
        $validated['order'] = $validated['order'] ?? 0;

        // Handle payment methods
        if ($request->has('payment_methods')) {
            $validated['payment_methods'] = $request->payment_methods;
        }

        Donation::create($validated);

        return redirect()->route('admin.donations.index')
            ->with('success', 'Campaign donasi berhasil ditambahkan!');
    }

    public function show(Donation $donation)
    {
        $donation->load(['transactions' => function ($query) {
            $query->latest()->take(10);
        }]);

        return view('admin.donations.show', compact('donation'));
    }

    public function edit(Donation $donation)
    {
        return view('admin.donations.edit', compact('donation'));
    }

    public function update(Request $request, Donation $donation)
    {
        $validated = $request->validate([
            'campaign_name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:donations,slug,' . $donation->id,
            'description' => 'required|string',
            'content' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'category' => 'required|in:infaq,sedekah,zakat,wakaf,qurban,renovation,program,other',
            'target_amount' => 'nullable|numeric|min:0',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'is_urgent' => 'boolean',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
            'order' => 'nullable|integer|min:0',
            'payment_methods' => 'nullable|array',
        ]);

        // Generate slug if not provided
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['campaign_name']);
        }

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image
            if ($donation->image) {
                Storage::disk('public')->delete($donation->image);
            }
            $validated['image'] = $request->file('image')->store('donations', 'public');
        }

        // Handle checkboxes
        $validated['is_urgent'] = $request->has('is_urgent');
        $validated['is_featured'] = $request->has('is_featured');
        $validated['is_active'] = $request->has('is_active');
        $validated['order'] = $validated['order'] ?? $donation->order;

        // Handle payment methods
        if ($request->has('payment_methods')) {
            $validated['payment_methods'] = $request->payment_methods;
        } else {
            $validated['payment_methods'] = [];
        }

        $donation->update($validated);

        return redirect()->route('admin.donations.index')
            ->with('success', 'Campaign donasi berhasil diupdate!');
    }

    public function destroy(Donation $donation)
    {
        if ($donation->image) {
            Storage::disk('public')->delete($donation->image);
        }

        $donation->delete();

        return redirect()->route('admin.donations.index')
            ->with('success', 'Campaign donasi berhasil dihapus!');
    }

    public function toggleActive(Donation $donation)
    {
        $donation->update(['is_active' => !$donation->is_active]);

        $status = $donation->is_active ? 'diaktifkan' : 'dinonaktifkan';
        return back()->with('success', "Campaign donasi berhasil {$status}!");
    }

    public function toggleFeatured(Donation $donation)
    {
        $donation->update(['is_featured' => !$donation->is_featured]);

        $status = $donation->is_featured ? 'difeatured' : 'diunfeatured';
        return back()->with('success', "Campaign donasi berhasil {$status}!");
    }
}
