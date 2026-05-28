<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SocialEmbedController extends Controller
{
    /**
     * Show Social Embed edit page.
     */
    public function index()
    {
        $embeds = [
            'ig_post_1' => Setting::get('ig_post_1', 'C-v1M-LykbU'),
            'ig_post_2' => Setting::get('ig_post_2', 'C-v0_Z_S2c7'),
            'ig_post_3' => Setting::get('ig_post_3', 'C-v01qNSsL4'),
            'yt_video_1' => Setting::get('yt_video_1', 'LXb3EKWsInQ'),
            'yt_video_2' => Setting::get('yt_video_2', 'wXhTHyIgQ_U'),
            'yt_video_3' => Setting::get('yt_video_3', 'jfKfPfyJRdk'),
        ];

        return view('admin.social-embeds.index', compact('embeds'));
    }

    /**
     * Update Social Embed settings.
     */
    public function update(Request $request)
    {
        $request->validate([
            'ig_post_1' => 'nullable|string',
            'ig_post_2' => 'nullable|string',
            'ig_post_3' => 'nullable|string',
            'yt_video_1' => 'nullable|string',
            'yt_video_2' => 'nullable|string',
            'yt_video_3' => 'nullable|string',
        ]);

        Setting::set('ig_post_1', $request->ig_post_1);
        Setting::set('ig_post_2', $request->ig_post_2);
        Setting::set('ig_post_3', $request->ig_post_3);
        Setting::set('yt_video_1', $request->yt_video_1);
        Setting::set('yt_video_2', $request->yt_video_2);
        Setting::set('yt_video_3', $request->yt_video_3);

        activity()
            ->causedBy(auth()->user())
            ->log('Mengubah Pengaturan Sosial Embed Landing Page');

        return redirect()
            ->route('admin.social-embeds.index')
            ->with('success', 'Pengaturan Sosial Embed berhasil diperbarui!');
    }
}
