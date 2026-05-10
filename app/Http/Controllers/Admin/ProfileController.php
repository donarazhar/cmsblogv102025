<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    /**
     * Show profile overview/index page.
     */
    public function index()
    {
        $profileData = [
            'sejarah' => Setting::get('profile_sejarah', ''),
            'visi_misi' => Setting::get('profile_visi_misi', ''),
            'struktur_organisasi' => Setting::get('profile_struktur_organisasi', ''),
        ];

        return view('admin.profile.index', compact('profileData'));
    }

    /**
     * Show Sejarah Masjid edit page.
     */
    public function sejarah()
    {
        $content = Setting::get('profile_sejarah', '');
        return view('admin.profile.sejarah', compact('content'));
    }

    /**
     * Update Sejarah Masjid.
     */
    public function updateSejarah(Request $request)
    {
        $request->validate([
            'content' => 'required|string',
        ], [
            'content.required' => 'Konten sejarah masjid harus diisi.',
        ]);

        Setting::set('profile_sejarah', $request->content);

        activity()
            ->causedBy(auth()->user())
            ->log('Profil Sejarah Masjid diperbarui');

        return redirect()
            ->route('admin.profile.sejarah')
            ->with('success', 'Sejarah Masjid berhasil diperbarui!');
    }

    /**
     * Show Visi Misi edit page.
     */
    public function visiMisi()
    {
        $content = Setting::get('profile_visi_misi', '');
        return view('admin.profile.visi-misi', compact('content'));
    }

    /**
     * Update Visi Misi.
     */
    public function updateVisiMisi(Request $request)
    {
        $request->validate([
            'content' => 'required|string',
        ], [
            'content.required' => 'Konten visi misi harus diisi.',
        ]);

        Setting::set('profile_visi_misi', $request->content);

        activity()
            ->causedBy(auth()->user())
            ->log('Profil Visi Misi diperbarui');

        return redirect()
            ->route('admin.profile.visi-misi')
            ->with('success', 'Visi & Misi berhasil diperbarui!');
    }

    /**
     * Show Struktur Organisasi edit page.
     */
    public function strukturOrganisasi()
    {
        $content = Setting::get('profile_struktur_organisasi', '');
        return view('admin.profile.struktur-organisasi', compact('content'));
    }

    /**
     * Update Struktur Organisasi.
     */
    public function updateStrukturOrganisasi(Request $request)
    {
        $request->validate([
            'content' => 'required|string',
        ], [
            'content.required' => 'Konten struktur organisasi harus diisi.',
        ]);

        Setting::set('profile_struktur_organisasi', $request->content);

        activity()
            ->causedBy(auth()->user())
            ->log('Profil Struktur Organisasi diperbarui');

        return redirect()
            ->route('admin.profile.struktur-organisasi')
            ->with('success', 'Struktur Organisasi berhasil diperbarui!');
    }
}
