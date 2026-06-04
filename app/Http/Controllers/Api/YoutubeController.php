<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class YoutubeController extends Controller
{
    public function index()
    {
        // YouTube videos are stored as IDs in settings
        $video1 = \App\Models\Setting::where('key', 'yt_video_1')->first()->value ?? 'LXb3EKWsInQ';
        $video2 = \App\Models\Setting::where('key', 'yt_video_2')->first()->value ?? 'wXhTHyIgQ_U';
        $video3 = \App\Models\Setting::where('key', 'yt_video_3')->first()->value ?? 'jfKfPfyJRdk';

        $videos = [
            [
                'id' => $video1,
                'link' => 'https://www.youtube.com/watch?v=' . $video1,
                'gambar' => 'https://img.youtube.com/vi/' . $video1 . '/hqdefault.jpg'
            ],
            [
                'id' => $video2,
                'link' => 'https://www.youtube.com/watch?v=' . $video2,
                'gambar' => 'https://img.youtube.com/vi/' . $video2 . '/hqdefault.jpg'
            ],
            [
                'id' => $video3,
                'link' => 'https://www.youtube.com/watch?v=' . $video3,
                'gambar' => 'https://img.youtube.com/vi/' . $video3 . '/hqdefault.jpg'
            ]
        ];

        // Filter out empty IDs just in case
        $videos = array_values(array_filter($videos, function($v) { return !empty($v['id']); }));

        return response()->json([
            'success' => true,
            'message' => 'YouTube Gallery',
            'data'    => $videos
        ]);
    }
}
