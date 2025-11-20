<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GalleryAlbum;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class GalleryAlbumController extends Controller
{
    public function index()
    {
        $albums = GalleryAlbum::withCount('galleries')
            ->latest('event_date')
            ->paginate(12);

        return view('admin.gallery.albums.index', compact('albums'));
    }

    public function create()
    {
        return view('admin.gallery.albums.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:gallery_albums,slug',
            'description' => 'nullable|string',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'event_date' => 'nullable|date',
            'location' => 'nullable|string|max:255',
            'is_active' => 'boolean',
        ], [
            'name.required' => 'Nama album harus diisi',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        if ($request->hasFile('cover_image')) {
            $validated['cover_image'] = $request->file('cover_image')->store('gallery/covers', 'public');
        }

        $validated['is_active'] = $request->has('is_active') ? 1 : 0;

        GalleryAlbum::create($validated);

        return redirect()
            ->route('admin.gallery.albums.index')
            ->with('success', 'Album berhasil ditambahkan!');
    }

    public function edit(GalleryAlbum $album)
    {
        return view('admin.gallery.albums.edit', compact('album'));
    }

    public function update(Request $request, GalleryAlbum $album)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:gallery_albums,slug,' . $album->id,
            'description' => 'nullable|string',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'event_date' => 'nullable|date',
            'location' => 'nullable|string|max:255',
            'is_active' => 'boolean',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        if ($request->hasFile('cover_image')) {
            if ($album->cover_image) {
                Storage::disk('public')->delete($album->cover_image);
            }
            $validated['cover_image'] = $request->file('cover_image')->store('gallery/covers', 'public');
        }

        $validated['is_active'] = $request->has('is_active') ? 1 : 0;

        $album->update($validated);

        return redirect()
            ->route('admin.gallery.albums.index')
            ->with('success', 'Album berhasil diupdate!');
    }

    public function destroy(GalleryAlbum $album)
    {
        // Delete cover image
        if ($album->cover_image) {
            Storage::disk('public')->delete($album->cover_image);
        }

        // Delete all photos in album
        foreach ($album->galleries as $photo) {
            if ($photo->image) {
                Storage::disk('public')->delete($photo->image);
            }
            $photo->delete();
        }

        $album->delete();

        return redirect()
            ->route('admin.gallery.albums.index')
            ->with('success', 'Album dan semua foto berhasil dihapus!');
    }

    public function toggleStatus(GalleryAlbum $album)
    {
        $album->update(['is_active' => !$album->is_active]);

        $status = $album->is_active ? 'diaktifkan' : 'dinonaktifkan';

        return redirect()
            ->route('admin.gallery.albums.index')
            ->with('success', "Album berhasil {$status}!");
    }
}
