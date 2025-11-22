<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class TagController extends Controller
{
    public function index(Request $request)
    {
        $query = Tag::query()->withCount('posts');

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('is_active', $request->status === 'active');
        }

        // Sort
        $sortField = $request->get('sort', 'created_at');
        $sortDirection = $request->get('direction', 'desc');
        $query->orderBy($sortField, $sortDirection);

        $tags = $query->paginate(15)->withQueryString();

        return view('admin.tags.index', compact('tags'));
    }

    public function create()
    {
        return view('admin.tags.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:tags,name',
            'slug' => 'nullable|string|max:255|unique:tags,slug',
            'description' => 'nullable|string|max:1000',
            'color' => 'required|string|regex:/^#[0-9A-Fa-f]{6}$/',
            'is_active' => 'boolean',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        } else {
            $validated['slug'] = Str::slug($validated['slug']);
        }

        $validated['is_active'] = $request->has('is_active');

        Tag::create($validated);

        return redirect()->route('admin.tags.index')
            ->with('success', 'Tag berhasil dibuat!');
    }

    public function show(Tag $tag)
    {
        $posts = $tag->posts()
            ->with(['category', 'author'])
            ->latest()
            ->paginate(10);

        return view('admin.tags.show', compact('tag', 'posts'));
    }

    public function edit(Tag $tag)
    {
        return view('admin.tags.edit', compact('tag'));
    }

    public function update(Request $request, Tag $tag)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('tags')->ignore($tag->id)],
            'slug' => ['nullable', 'string', 'max:255', Rule::unique('tags')->ignore($tag->id)],
            'description' => 'nullable|string|max:1000',
            'color' => 'required|string|regex:/^#[0-9A-Fa-f]{6}$/',
            'is_active' => 'boolean',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        } else {
            $validated['slug'] = Str::slug($validated['slug']);
        }

        $validated['is_active'] = $request->has('is_active');

        $tag->update($validated);

        return redirect()->route('admin.tags.index')
            ->with('success', 'Tag berhasil diperbarui!');
    }

    public function destroy(Tag $tag)
    {
        $postsCount = $tag->posts()->count();

        if ($postsCount > 0) {
            return redirect()->route('admin.tags.index')
                ->with('info', "Tag tidak dapat dihapus karena masih digunakan oleh {$postsCount} post.");
        }

        $tag->delete();

        return redirect()->route('admin.tags.index')
            ->with('success', 'Tag berhasil dihapus!');
    }

    public function bulkDelete(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:tags,id',
        ]);

        $tags = Tag::whereIn('id', $request->ids)->get();
        $deleted = 0;
        $skipped = 0;

        foreach ($tags as $tag) {
            if ($tag->posts()->count() > 0) {
                $skipped++;
            } else {
                $tag->delete();
                $deleted++;
            }
        }

        $message = "Berhasil menghapus {$deleted} tag.";
        if ($skipped > 0) {
            $message .= " {$skipped} tag dilewati karena masih digunakan.";
        }

        return redirect()->route('admin.tags.index')
            ->with('success', $message);
    }
}
