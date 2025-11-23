<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Program;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProgramController extends Controller
{
    public function index()
    {
        try {
            $programs = Program::withCount('registrations')
                ->ordered()
                ->paginate(15);
        } catch (\Exception $e) {
            $programs = Program::ordered()->paginate(15);
        }

        return view('admin.programs.index', compact('programs'));
    }

    public function create()
    {
        return view('admin.programs.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:programs,slug',
            'description' => 'required|string',
            'content' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'icon' => 'nullable|string|max:100',
            'type' => 'required|in:regular,event,course,charity',
            'frequency' => 'nullable|in:daily,weekly,monthly,yearly,once',
            'location' => 'nullable|string|max:255',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'start_time' => 'nullable',
            'end_time' => 'nullable',
            'registration_fee' => 'nullable|numeric|min:0',
            'max_participants' => 'nullable|integer|min:1',
            'organizer' => 'nullable|string|max:255',
            'speaker' => 'nullable|string|max:255',
            'contact_person' => 'nullable|string|max:255',
            'contact_phone' => 'nullable|string|max:20',
            'order' => 'nullable|integer|min:0',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);

            // Check for duplicate slug
            $count = Program::where('slug', 'LIKE', $validated['slug'] . '%')->count();
            if ($count > 0) {
                $validated['slug'] = $validated['slug'] . '-' . ($count + 1);
            }
        }

        // ✅ PERBAIKAN: Handle image dengan isValid()
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $validated['image'] = $request->file('image')->store('programs', 'public');
        }

        $validated['is_active'] = $request->has('is_active') ? 1 : 0;
        $validated['is_featured'] = $request->has('is_featured') ? 1 : 0;
        $validated['is_registration_open'] = $request->has('is_registration_open') ? 1 : 0;
        $validated['current_participants'] = 0;

        if (!isset($validated['order'])) {
            $validated['order'] = (Program::max('order') ?? 0) + 1;
        }

        Program::create($validated);

        return redirect()
            ->route('admin.programs.index')
            ->with('success', 'Program berhasil ditambahkan!');
    }

    public function edit(Program $program)
    {
        return view('admin.programs.edit', compact('program'));
    }

    public function update(Request $request, Program $program)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:programs,slug,' . $program->id,
            'description' => 'required|string',
            'content' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'icon' => 'nullable|string|max:100',
            'type' => 'required|in:regular,event,course,charity',
            'frequency' => 'nullable|in:daily,weekly,monthly,yearly,once',
            'location' => 'nullable|string|max:255',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'start_time' => 'nullable',
            'end_time' => 'nullable',
            'registration_fee' => 'nullable|numeric|min:0',
            'max_participants' => 'nullable|integer|min:1',
            'organizer' => 'nullable|string|max:255',
            'speaker' => 'nullable|string|max:255',
            'contact_person' => 'nullable|string|max:255',
            'contact_phone' => 'nullable|string|max:20',
            'order' => 'nullable|integer|min:0',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        // ✅ PERBAIKAN: Handle image dengan isValid()
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            if ($program->image && Storage::disk('public')->exists($program->image)) {
                Storage::disk('public')->delete($program->image);
            }
            $validated['image'] = $request->file('image')->store('programs', 'public');
        }

        $validated['is_active'] = $request->has('is_active') ? 1 : 0;
        $validated['is_featured'] = $request->has('is_featured') ? 1 : 0;
        $validated['is_registration_open'] = $request->has('is_registration_open') ? 1 : 0;

        $program->update($validated);

        return redirect()
            ->route('admin.programs.index')
            ->with('success', 'Program berhasil diupdate!');
    }

    public function destroy(Program $program)
    {
        if ($program->image && Storage::disk('public')->exists($program->image)) {
            Storage::disk('public')->delete($program->image);
        }

        $program->delete();

        return redirect()
            ->route('admin.programs.index')
            ->with('success', 'Program berhasil dihapus!');
    }

    public function toggleStatus(Program $program)
    {
        $program->update(['is_active' => !$program->is_active]);

        $status = $program->is_active ? 'diaktifkan' : 'dinonaktifkan';

        return redirect()->back()->with('success', "Program berhasil {$status}!");
    }

    public function toggleFeatured(Program $program)
    {
        $program->update(['is_featured' => !$program->is_featured]);

        $status = $program->is_featured ? 'ditampilkan di featured' : 'dihapus dari featured';

        return redirect()->back()->with('success', "Program berhasil {$status}!");
    }

    /**
     * Upload image for TinyMCE editor
     */
    public function uploadImage(Request $request)
    {
        $request->validate([
            'file' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        if ($request->hasFile('file') && $request->file('file')->isValid()) {
            $path = $request->file('file')->store('programs/content', 'public');

            return response()->json([
                'location' => asset('storage/' . $path)
            ]);
        }

        return response()->json(['error' => 'Upload failed'], 400);
    }
}
