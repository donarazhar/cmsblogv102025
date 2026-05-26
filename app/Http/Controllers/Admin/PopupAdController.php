<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PopupAd;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PopupAdController extends Controller
{
    public function index()
    {
        $popupAds = PopupAd::ordered()->paginate(10);
        return view('admin.popup-ads.index', compact('popupAds'));
    }

    public function create()
    {
        return view('admin.popup-ads.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'banner_image' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
            'pdf_file' => 'nullable|file|mimes:pdf|max:10240',
            'external_link' => 'nullable|url|max:255',
            'target_routes' => 'nullable|string|max:255',
            'is_active' => 'boolean',
            'show_delay' => 'required|integer|min:0',
            'order' => 'nullable|integer|min:0',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        if ($request->hasFile('banner_image')) {
            $validated['banner_image'] = $request->file('banner_image')->store('popup-ads/images', 'public');
        }

        if ($request->hasFile('pdf_file')) {
            $validated['pdf_file'] = $request->file('pdf_file')->store('popup-ads/pdfs', 'public');
        }

        $validated['is_active'] = $request->has('is_active') ? 1 : 0;

        if (!isset($validated['order'])) {
            $maxOrder = PopupAd::max('order') ?? 0;
            $validated['order'] = $maxOrder + 1;
        }

        PopupAd::create($validated);

        return redirect()->route('admin.popup-ads.index')->with('success', 'Popup iklan berhasil ditambahkan!');
    }

    public function edit(PopupAd $popupAd)
    {
        return view('admin.popup-ads.edit', compact('popupAd'));
    }

    public function update(Request $request, PopupAd $popupAd)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'banner_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'pdf_file' => 'nullable|file|mimes:pdf|max:10240',
            'external_link' => 'nullable|url|max:255',
            'target_routes' => 'nullable|string|max:255',
            'is_active' => 'boolean',
            'show_delay' => 'required|integer|min:0',
            'order' => 'nullable|integer|min:0',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        if ($request->hasFile('banner_image')) {
            if ($popupAd->banner_image && Storage::disk('public')->exists($popupAd->banner_image)) {
                Storage::disk('public')->delete($popupAd->banner_image);
            }
            $validated['banner_image'] = $request->file('banner_image')->store('popup-ads/images', 'public');
        }

        if ($request->hasFile('pdf_file')) {
            if ($popupAd->pdf_file && Storage::disk('public')->exists($popupAd->pdf_file)) {
                Storage::disk('public')->delete($popupAd->pdf_file);
            }
            $validated['pdf_file'] = $request->file('pdf_file')->store('popup-ads/pdfs', 'public');
        }

        if ($request->has('remove_pdf_file') && $request->remove_pdf_file == '1') {
             if ($popupAd->pdf_file && Storage::disk('public')->exists($popupAd->pdf_file)) {
                Storage::disk('public')->delete($popupAd->pdf_file);
            }
            $validated['pdf_file'] = null;
        }

        $validated['is_active'] = $request->has('is_active') ? 1 : 0;

        $popupAd->update($validated);

        return redirect()->route('admin.popup-ads.index')->with('success', 'Popup iklan berhasil diupdate!');
    }

    public function destroy(PopupAd $popupAd)
    {
        if ($popupAd->banner_image && Storage::disk('public')->exists($popupAd->banner_image)) {
            Storage::disk('public')->delete($popupAd->banner_image);
        }

        if ($popupAd->pdf_file && Storage::disk('public')->exists($popupAd->pdf_file)) {
            Storage::disk('public')->delete($popupAd->pdf_file);
        }

        $popupAd->delete();

        return redirect()->route('admin.popup-ads.index')->with('success', 'Popup iklan berhasil dihapus!');
    }

    public function toggleStatus(PopupAd $popupAd)
    {
        // Jika diaktifkan, nonaktifkan popup lain (opsional: agar hanya 1 popup aktif)
        // Disini kita membolehkan banyak popup, tapi frontend mungkin hanya ambil 1
        $popupAd->update(['is_active' => !$popupAd->is_active]);

        $status = $popupAd->is_active ? 'diaktifkan' : 'dinonaktifkan';

        return redirect()->route('admin.popup-ads.index')->with('success', "Popup iklan berhasil {$status}!");
    }
}
