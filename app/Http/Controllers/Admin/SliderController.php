<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SliderController extends Controller
{
    public function index()
    {
        $sliders = Slider::ordered()->paginate(10);

        return view('admin.sliders.index', compact('sliders'));
    }

    public function create()
    {
        return view('admin.sliders.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
            'button_text' => 'nullable|string|max:100',
            'button_link' => 'nullable|url|max:255',
            'button_text_2' => 'nullable|string|max:100',
            'button_link_2' => 'nullable|url|max:255',
            'text_position' => 'required|in:left,center,right',
            'overlay_color' => 'nullable|string|max:7',
            'overlay_opacity' => 'nullable|integer|min:0|max:100',
            'order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('sliders', 'public');
        }

        $validated['is_active'] = $request->has('is_active') ? 1 : 0;
        $validated['overlay_opacity'] = $validated['overlay_opacity'] ?? 50;

        if (!isset($validated['order'])) {
            $maxOrder = Slider::max('order') ?? 0;
            $validated['order'] = $maxOrder + 1;
        }

        Slider::create($validated);

        return redirect()->route('admin.sliders.index')->with('success', 'Slider berhasil ditambahkan!');
    }

    public function edit(Slider $slider)
    {
        return view('admin.sliders.edit', compact('slider'));
    }

    public function update(Request $request, Slider $slider)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'button_text' => 'nullable|string|max:100',
            'button_link' => 'nullable|url|max:255',
            'button_text_2' => 'nullable|string|max:100',
            'button_link_2' => 'nullable|url|max:255',
            'text_position' => 'required|in:left,center,right',
            'overlay_color' => 'nullable|string|max:7',
            'overlay_opacity' => 'nullable|integer|min:0|max:100',
            'order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ]);

        if ($request->hasFile('image')) {
            if ($slider->image) {
                Storage::disk('public')->delete($slider->image);
            }
            $validated['image'] = $request->file('image')->store('sliders', 'public');
        }

        $validated['is_active'] = $request->has('is_active') ? 1 : 0;

        $slider->update($validated);

        return redirect()->route('admin.sliders.index')->with('success', 'Slider berhasil diupdate!');
    }

    public function destroy(Slider $slider)
    {
        if ($slider->image) {
            Storage::disk('public')->delete($slider->image);
        }

        $slider->delete();

        return redirect()->route('admin.sliders.index')->with('success', 'Slider berhasil dihapus!');
    }

    public function toggleStatus(Slider $slider)
    {
        $slider->update(['is_active' => !$slider->is_active]);

        $status = $slider->is_active ? 'diaktifkan' : 'dinonaktifkan';

        return redirect()->route('admin.sliders.index')->with('success', "Slider berhasil {$status}!");
    }

    public function updateOrder(Request $request)
    {
        $orders = $request->input('orders', []);

        foreach ($orders as $order => $id) {
            Slider::where('id', $id)->update(['order' => $order + 1]);
        }

        return response()->json(['success' => true, 'message' => 'Urutan slider berhasil diupdate!']);
    }
}
