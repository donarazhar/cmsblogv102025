<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdBanner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdBannerController extends Controller
{
    public function index()
    {
        $adBanners = AdBanner::ordered()->paginate(10);
        return view('admin.ad_banners.index', compact('adBanners'));
    }

    public function create()
    {
        return view('admin.ad_banners.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
            'url_link' => 'nullable|url|max:255',
            'target_routes' => 'nullable|string',
            'order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('ad_banners', 'public');
        }

        $validated['is_active'] = $request->has('is_active') ? 1 : 0;

        if (!isset($validated['order'])) {
            $maxOrder = AdBanner::max('order') ?? 0;
            $validated['order'] = $maxOrder + 1;
        }

        AdBanner::create($validated);

        return redirect()->route('admin.ad-banners.index')->with('success', 'Ads Banner berhasil ditambahkan!');
    }

    public function edit(AdBanner $adBanner)
    {
        return view('admin.ad_banners.edit', compact('adBanner'));
    }

    public function update(Request $request, AdBanner $adBanner)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'url_link' => 'nullable|url|max:255',
            'target_routes' => 'nullable|string',
            'order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ]);

        if ($request->hasFile('image')) {
            if ($adBanner->image) {
                Storage::disk('public')->delete($adBanner->image);
            }
            $validated['image'] = $request->file('image')->store('ad_banners', 'public');
        }

        $validated['is_active'] = $request->has('is_active') ? 1 : 0;

        $adBanner->update($validated);

        return redirect()->route('admin.ad-banners.index')->with('success', 'Ads Banner berhasil diupdate!');
    }

    public function destroy(AdBanner $adBanner)
    {
        if ($adBanner->image) {
            Storage::disk('public')->delete($adBanner->image);
        }
        $adBanner->delete();

        return redirect()->route('admin.ad-banners.index')->with('success', 'Ads Banner berhasil dihapus!');
    }

    public function toggleStatus(AdBanner $adBanner)
    {
        $adBanner->update(['is_active' => !$adBanner->is_active]);
        $status = $adBanner->is_active ? 'diaktifkan' : 'dinonaktifkan';
        return redirect()->route('admin.ad-banners.index')->with('success', "Ads Banner berhasil {$status}!");
    }

    public function updateOrder(Request $request)
    {
        $orders = $request->input('orders', []);
        foreach ($orders as $order => $id) {
            AdBanner::where('id', $id)->update(['order' => $order + 1]);
        }
        return response()->json(['success' => true, 'message' => 'Urutan ads banner berhasil diupdate!']);
    }
}
