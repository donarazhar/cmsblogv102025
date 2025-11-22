<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function index()
    {
        $settings = Setting::ordered()->get()->groupBy('group');
        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        try {
            // Log untuk debugging
            \Log::info('Settings Update Started', [
                'settings_count' => count($request->input('settings', [])),
                'has_files' => count($request->allFiles())
            ]);

            $settings = $request->input('settings', []);

            foreach ($settings as $key => $value) {
                $setting = Setting::where('key', $key)->first();

                if (!$setting) {
                    \Log::warning("Setting not found: {$key}");
                    continue;
                }

                // Handle file uploads
                if (in_array($setting->type, ['image', 'file'])) {
                    if ($request->hasFile("settings.{$key}")) {
                        // Validate file
                        $request->validate([
                            "settings.{$key}" => 'image|mimes:jpeg,png,jpg,gif|max:2048'
                        ]);

                        // Delete old file
                        if ($setting->value && Storage::disk('public')->exists($setting->value)) {
                            Storage::disk('public')->delete($setting->value);
                        }

                        // Upload new file
                        $file = $request->file("settings.{$key}");
                        $path = $file->store('settings', 'public');

                        Setting::set($key, $path);
                        \Log::info("File uploaded for {$key}: {$path}");
                    }
                    // Skip jika tidak ada file baru
                    continue;
                }

                // Handle boolean (sudah ada value 0 dari hidden input)
                if ($setting->type === 'boolean') {
                    $value = $value == '1' ? '1' : '0';
                }

                // Update setting
                Setting::set($key, $value);
                \Log::info("Setting updated: {$key} = {$value}");
            }

            \Log::info('Settings Update Completed Successfully');

            return redirect()->route('admin.settings.index')
                ->with('success', 'Pengaturan berhasil diperbarui!');
        } catch (\Exception $e) {
            \Log::error('Settings Update Failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->route('admin.settings.index')
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function create()
    {
        $groups = ['general', 'contact', 'social', 'seo', 'appearance'];
        return view('admin.settings.create', compact('groups'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'key' => 'required|string|unique:settings,key|max:255|regex:/^[a-z0-9_]+$/',
            'label' => 'required|string|max:255',
            'value' => 'nullable|string',
            'type' => 'required|in:text,textarea,email,url,number,boolean,image,file',
            'group' => 'required|string|max:255',
            'description' => 'nullable|string',
            'order' => 'nullable|integer|min:0',
        ], [
            'key.regex' => 'Key hanya boleh menggunakan huruf kecil, angka, dan underscore',
        ]);

        $validated['order'] = $validated['order'] ?? 0;

        Setting::create($validated);

        return redirect()->route('admin.settings.index')
            ->with('success', 'Setting baru berhasil ditambahkan!');
    }

    public function destroy(Setting $setting)
    {
        // Delete file if exists
        if (in_array($setting->type, ['image', 'file']) && $setting->value) {
            if (Storage::disk('public')->exists($setting->value)) {
                Storage::disk('public')->delete($setting->value);
            }
        }

        $setting->delete();

        return redirect()->route('admin.settings.index')
            ->with('success', 'Setting berhasil dihapus!');
    }

    public function clearCache()
    {
        Setting::clearCache();

        return redirect()->route('admin.settings.index')
            ->with('success', 'Cache berhasil dibersihkan!');
    }
}
