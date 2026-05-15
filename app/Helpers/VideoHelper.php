<?php

namespace App\Helpers;

class VideoHelper
{
    /**
     * Convert a YouTube or Vimeo URL to an embed URL
     *
     * Supported formats:
     * - https://www.youtube.com/watch?v=VIDEO_ID
     * - https://youtu.be/VIDEO_ID
     * - https://www.youtube.com/embed/VIDEO_ID
     * - https://vimeo.com/VIDEO_ID
     * - https://player.vimeo.com/video/VIDEO_ID
     */
    public static function getEmbedUrl(?string $url): ?string
    {
        if (empty($url)) {
            return null;
        }

        // Already an embed URL
        if (str_contains($url, 'youtube.com/embed/') || str_contains($url, 'player.vimeo.com/video/')) {
            return $url;
        }

        // YouTube: https://www.youtube.com/watch?v=VIDEO_ID
        if (preg_match('/(?:youtube\.com\/watch\?v=|youtu\.be\/)([a-zA-Z0-9_-]+)/', $url, $matches)) {
            return 'https://www.youtube.com/embed/' . $matches[1] . '?rel=0';
        }

        // Vimeo: https://vimeo.com/VIDEO_ID
        if (preg_match('/vimeo\.com\/(\d+)/', $url, $matches)) {
            return 'https://player.vimeo.com/video/' . $matches[1];
        }

        // Return original URL as fallback
        return $url;
    }

    /**
     * Get video thumbnail from YouTube URL
     */
    public static function getYouTubeThumbnail(?string $url): ?string
    {
        if (empty($url)) {
            return null;
        }

        if (preg_match('/(?:youtube\.com\/watch\?v=|youtu\.be\/|youtube\.com\/embed\/)([a-zA-Z0-9_-]+)/', $url, $matches)) {
            return 'https://img.youtube.com/vi/' . $matches[1] . '/maxresdefault.jpg';
        }

        return null;
    }

    /**
     * Check if URL is a valid video URL (YouTube or Vimeo)
     */
    public static function isVideoUrl(?string $url): bool
    {
        if (empty($url)) {
            return false;
        }

        return (bool) preg_match('/(?:youtube\.com|youtu\.be|vimeo\.com)/', $url);
    }
}
