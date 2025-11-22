<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PageController extends Controller
{
    public function index(Request $request)
    {
        $query = Page::with('parent');

        // Filter by status
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        // Filter by template
        if ($request->has('template') && $request->template != '') {
            $query->where('template', $request->template);
        }

        // Filter by parent
        if ($request->has('parent') && $request->parent != '') {
            if ($request->parent == 'none') {
                $query->whereNull('parent_id');
            } else {
                $query->where('parent_id', $request->parent);
            }
        }

        // Search
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('slug', 'like', "%{$search}%")
                    ->orWhere('content', 'like', "%{$search}%");
            });
        }

        $pages = $query->orderBy('menu_order', 'asc')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        // Get all parent pages for filter
        $parentPages = Page::whereNull('parent_id')->get();

        return view('admin.pages.index', compact('pages', 'parentPages'));
    }

    public function create()
    {
        $parentPages = Page::whereNull('parent_id')->get();
        return view('admin.pages.create', compact('parentPages'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:pages,slug',
            'content' => 'required|string',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'template' => 'required|in:default,full-width,sidebar-left,sidebar-right,contact,about',
            'status' => 'required|in:draft,published,private',
            'show_in_menu' => 'boolean',
            'menu_order' => 'nullable|integer|min:0',
            'parent_id' => 'nullable|exists:pages,id',
            'icon' => 'nullable|string|max:50',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'meta_keywords' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $data = $request->all();
        
        // Generate slug if not provided
        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['title']);
        } else {
            $data['slug'] = Str::slug($data['slug']);
        }

        // Handle featured image upload
        if ($request->hasFile('featured_image')) {
            $image = $request->file('featured_image');
            $filename = time() . '_' . Str::slug(pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $image->getClientOriginalExtension();
            $path = $image->storeAs('pages', $filename, 'public');
            $data['featured_image'] = $path;
        }

        $data['show_in_menu'] = $request->has('show_in_menu') ? 1 : 0;

        // Set default menu order if not provided
        if (empty($data['menu_order'])) {
            $maxOrder = Page::max('menu_order') ?? 0;
            $data['menu_order'] = $maxOrder + 1;
        }

        Page::create($data);

        return redirect()->route('admin.pages.index')
            ->with('success', 'Halaman berhasil ditambahkan!');
    }

    public function show(Page $page)
    {
        $page->load('parent', 'children');
        return view('admin.pages.show', compact('page'));
    }

    public function edit(Page $page)
    {
        $parentPages = Page::whereNull('parent_id')
            ->where('id', '!=', $page->id)
            ->get();
        return view('admin.pages.edit', compact('page', 'parentPages'));
    }

    public function update(Request $request, Page $page)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:pages,slug,' . $page->id,
            'content' => 'required|string',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'template' => 'required|in:default,full-width,sidebar-left,sidebar-right,contact,about',
            'status' => 'required|in:draft,published,private',
            'show_in_menu' => 'boolean',
            'menu_order' => 'nullable|integer|min:0',
            'parent_id' => 'nullable|exists:pages,id',
            'icon' => 'nullable|string|max:50',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'meta_keywords' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $data = $request->all();
        
        // Generate slug if not provided
        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['title']);
        } else {
            $data['slug'] = Str::slug($data['slug']);
        }

        // Handle featured image upload
        if ($request->hasFile('featured_image')) {
            // Delete old image
            if ($page->featured_image && Storage::disk('public')->exists($page->featured_image)) {
                Storage::disk('public')->delete($page->featured_image);
            }

            $image = $request->file('featured_image');
            $filename = time() . '_' . Str::slug(pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $image->getClientOriginalExtension();
            $path = $image->storeAs('pages', $filename, 'public');
            $data['featured_image'] = $path;
        }

        $data['show_in_menu'] = $request->has('show_in_menu') ? 1 : 0;

        $page->update($data);

        return redirect()->route('admin.pages.index')
            ->with('success', 'Halaman berhasil diperbarui!');
    }

    public function destroy(Page $page)
    {
        // Delete featured image
        if ($page->featured_image && Storage::disk('public')->exists($page->featured_image)) {
            Storage::disk('public')->delete($page->featured_image);
        }

        $page->delete();

        return redirect()->route('admin.pages.index')
            ->with('success', 'Halaman berhasil dihapus!');
    }

    public function reorder(Request $request)
    {
        $items = $request->input('items', []);

        foreach ($items as $index => $id) {
            Page::where('id', $id)->update(['menu_order' => $index + 1]);
        }

        return response()->json(['success' => true]);
    }

    public function removeImage(Page $page)
    {
        if ($page->featured_image && Storage::disk('public')->exists($page->featured_image)) {
            Storage::disk('public')->delete($page->featured_image);
            $page->update(['featured_image' => null]);
        }

        return redirect()->back()
            ->with('success', 'Gambar berhasil dihapus!');
    }
}