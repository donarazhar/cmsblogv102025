<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use App\Models\GalleryAlbum;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller
{
    public function index(Request $request)
    {
        $query = Gallery::with('album')
        ->whereHas('album'); // ✅ Hanya ambil foto yang punya album

        // Filter by album
        if ($request->filled('album')) {
            $query->where('album_id', $request->album); // ✅ Ubah ke album_id
        }

        // Filter by type
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        $galleries = $query->ordered()->paginate(24);
        $albums = GalleryAlbum::active()->withCount('galleries')->ordered()->get();
        
        return view('admin.gallery.photos.index', compact('galleries', 'albums'));
    }

    public function create()
    {
        $albums = GalleryAlbum::active()->ordered()->get();
        
        return view('admin.gallery.photos.create', compact('albums'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'album_id' => 'required|exists:gallery_albums,id', // ✅ Ubah ke album_id
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,webp|max:5120',
            'type' => 'required|in:image,video',
            'video_url' => 'nullable|url',
            'order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
            'is_featured' => 'boolean',
        ], [
            'album_id.required' => 'Album harus dipilih', // ✅ Ubah message
            'title.required' => 'Judul foto harus diisi',
            'image.required' => 'Gambar harus diupload',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('gallery/photos', 'public');
        }

        $validated['is_active'] = $request->has('is_active') ? 1 : 0;
        $validated['is_featured'] = $request->has('is_featured') ? 1 : 0;

        if (!isset($validated['order'])) {
            $maxOrder = Gallery::where('album_id', $validated['album_id'])->max('order') ?? 0; // ✅ Ubah ke album_id
            $validated['order'] = $maxOrder + 1;
        }

        Gallery::create($validated);

        return redirect()
            ->route('admin.gallery.photos.index')
            ->with('success', 'Foto berhasil ditambahkan!');
    }

    public function edit(Gallery $photo)
    {
        $albums = GalleryAlbum::active()->ordered()->get();
        
        return view('admin.gallery.photos.edit', compact('photo', 'albums'));
    }

    public function update(Request $request, Gallery $photo)
    {
        $validated = $request->validate([
            'album_id' => 'required|exists:gallery_albums,id', // ✅ Ubah ke album_id
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'type' => 'required|in:image,video',
            'video_url' => 'nullable|url',
            'order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
            'is_featured' => 'boolean',
        ]);

        if ($request->hasFile('image')) {
            if ($photo->image) {
                Storage::disk('public')->delete($photo->image);
            }
            $validated['image'] = $request->file('image')->store('gallery/photos', 'public');
        }

        $validated['is_active'] = $request->has('is_active') ? 1 : 0;
        $validated['is_featured'] = $request->has('is_featured') ? 1 : 0;

        $photo->update($validated);

        return redirect()
            ->route('admin.gallery.photos.index')
            ->with('success', 'Foto berhasil diupdate!');
    }

    public function destroy(Gallery $photo)
    {
        if ($photo->image) {
            Storage::disk('public')->delete($photo->image);
        }

        $photo->delete();

        return redirect()
            ->route('admin.gallery.photos.index')
            ->with('success', 'Foto berhasil dihapus!');
    }

    public function toggleStatus(Gallery $photo)
    {
        $photo->update(['is_active' => !$photo->is_active]);
        
        $status = $photo->is_active ? 'diaktifkan' : 'dinonaktifkan';

        return redirect()
            ->route('admin.gallery.photos.index')
            ->with('success', "Foto berhasil {$status}!");
    }

    public function bulkUpload(Request $request)
    {
        $request->validate([
            'album_id' => 'required|exists:gallery_albums,id', // ✅ Ubah ke album_id
            'images.*' => 'required|image|mimes:jpeg,png,jpg,webp|max:5120',
        ]);

        $album = GalleryAlbum::findOrFail($request->album_id); // ✅ Ubah ke album_id
        $maxOrder = Gallery::where('album_id', $album->id)->max('order') ?? 0; // ✅ Ubah ke album_id

        foreach ($request->file('images') as $index => $image) {
            $path = $image->store('gallery/photos', 'public');
            
            Gallery::create([
                'album_id' => $album->id, // ✅ Ubah ke album_id
                'title' => 'Photo ' . ($index + 1),
                'image' => $path,
                'type' => 'image',
                'order' => $maxOrder + $index + 1,
                'is_active' => true,
                'is_featured' => false,
            ]);
        }

        return redirect()
            ->route('admin.gallery.photos.index')
            ->with('success', count($request->file('images')) . ' foto berhasil diupload!');
    }
}