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
            \Log::info('Settings Update Started');
            \Log::info('Request All:', $request->all());
            \Log::info('Files:', array_keys($request->allFiles()));

            // Ambil SEMUA settings dari database (bukan dari request)
            $allSettings = Setting::all();

            foreach ($allSettings as $setting) {
                $key = $setting->key;

                // Handle FILE/IMAGE types
                if (in_array($setting->type, ['image', 'file'])) {
                    $fileKey = "settings.{$key}";

                    // Check jika ada file yang diupload
                    if ($request->hasFile($fileKey)) {
                        \Log::info("File detected for {$key}");

                        $file = $request->file($fileKey);

                        // Validate file
                        $request->validate([
                            $fileKey => 'image|mimes:jpeg,png,jpg,gif,webp|max:2048'
                        ], [
                            "{$fileKey}.image" => "File {$setting->label} harus berupa gambar",
                            "{$fileKey}.mimes" => "Format gambar harus: JPEG, PNG, JPG, GIF, WEBP",
                            "{$fileKey}.max" => "Ukuran gambar maksimal 2MB"
                        ]);

                        // Delete old file if exists
                        if ($setting->value && Storage::disk('public')->exists($setting->value)) {
                            Storage::disk('public')->delete($setting->value);
                            \Log::info("Deleted old file: {$setting->value}");
                        }

                        // Upload new file
                        $path = $file->store('settings', 'public');

                        // Update setting value
                        $setting->value = $path;
                        $setting->save();

                        \Log::info("✅ File uploaded for {$key}: {$path}");
                    } else {
                        \Log::info("No file uploaded for {$key}, keeping current value");
                    }

                    continue; // Skip to next setting
                }

                // Handle NON-FILE types
                if ($request->has("settings.{$key}")) {
                    $value = $request->input("settings.{$key}");

                    // Handle boolean
                    if ($setting->type === 'boolean') {
                        $value = $value == '1' ? '1' : '0';
                    }

                    // Update setting
                    $setting->value = $value;
                    $setting->save();

                    \Log::info("Setting updated: {$key} = {$value}");
                }
            }

            \Log::info('Settings Update Completed Successfully');

            return redirect()->route('admin.settings.index')
                ->with('success', 'Pengaturan berhasil diperbarui!');
        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('Validation Failed', ['errors' => $e->errors()]);

            return redirect()->route('admin.settings.index')
                ->withErrors($e->errors())
                ->withInput()
                ->with('error', 'Validasi gagal! Periksa file yang diupload.');
        } catch (\Exception $e) {
            \Log::error('Settings Update Failed', [
                'error' => $e->getMessage(),
                'line' => $e->getLine(),
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
        $validated['value'] = $validated['value'] ?? '';

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
                \Log::info("Deleted file on setting destroy: {$setting->value}");
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
