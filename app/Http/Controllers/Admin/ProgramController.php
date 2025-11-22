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
        // Jika model ProgramRegistration ada, gunakan withCount
        // Jika tidak ada, jangan gunakan eager loading
        try {
            $programs = Program::withCount('registrations')
                ->ordered()
                ->paginate(15);
        } catch (\Exception $e) {
            // Fallback jika tabel registrations belum ada
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
            'start_time' => 'nullable|date_format:H:i',
            'end_time' => 'nullable|date_format:H:i|after:start_time',
            'registration_fee' => 'nullable|numeric|min:0',
            'max_participants' => 'nullable|integer|min:1',
            'organizer' => 'nullable|string|max:255',
            'speaker' => 'nullable|string|max:255',
            'contact_person' => 'nullable|string|max:255',
            'contact_phone' => 'nullable|string|max:20',
            'order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
            'is_featured' => 'boolean',
            'is_registration_open' => 'boolean',
        ], [
            'name.required' => 'Nama program harus diisi',
            'description.required' => 'Deskripsi program harus diisi',
            'type.required' => 'Tipe program harus dipilih',
            'end_date.after_or_equal' => 'Tanggal selesai harus setelah atau sama dengan tanggal mulai',
            'end_time.after' => 'Waktu selesai harus setelah waktu mulai',
        ]);

        // Generate slug if not provided
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        // Handle image upload
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('programs', 'public');
        }

        // Set defaults
        $validated['is_active'] = $request->has('is_active') ? 1 : 0;
        $validated['is_featured'] = $request->has('is_featured') ? 1 : 0;
        $validated['is_registration_open'] = $request->has('is_registration_open') ? 1 : 0;
        $validated['current_participants'] = 0;

        // Auto increment order
        if (!isset($validated['order'])) {
            $maxOrder = Program::max('order') ?? 0;
            $validated['order'] = $maxOrder + 1;
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
            'start_time' => 'nullable|date_format:H:i',
            'end_time' => 'nullable|date_format:H:i|after:start_time',
            'registration_fee' => 'nullable|numeric|min:0',
            'max_participants' => 'nullable|integer|min:1',
            'organizer' => 'nullable|string|max:255',
            'speaker' => 'nullable|string|max:255',
            'contact_person' => 'nullable|string|max:255',
            'contact_phone' => 'nullable|string|max:20',
            'order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
            'is_featured' => 'boolean',
            'is_registration_open' => 'boolean',
        ]);

        // Generate slug if not provided
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        // Handle image upload
        if ($request->hasFile('image')) {
            if ($program->image) {
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
        if ($program->image) {
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

        return redirect()
            ->route('admin.programs.index')
            ->with('success', "Program berhasil {$status}!");
    }

    public function toggleFeatured(Program $program)
    {
        $program->update(['is_featured' => !$program->is_featured]);

        $status = $program->is_featured ? 'ditampilkan di featured' : 'dihapus dari featured';

        return redirect()
            ->route('admin.programs.index')
            ->with('success', "Program berhasil {$status}!");
    }
}