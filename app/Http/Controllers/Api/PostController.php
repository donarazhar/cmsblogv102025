<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $query = Post::with(['category', 'author'])
            ->published()
            ->latest();

        if ($request->has('category')) {
            $query->whereHas('category', function($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        if ($request->has('search')) {
            $query->search($request->search);
        }

        $posts = $query->paginate($request->get('per_page', 10));

        $posts->getCollection()->transform(function($post) {
            $post->setAppends([]);
            if ($post->category) {
                $post->category->setAppends([]);
            }
            if ($post->author) {
                $post->author->setAppends([]);
            }
            return $post;
        });

        return response()->json([
            'success' => true,
            'message' => 'List Data Berita/Artikel',
            'data'    => $posts
        ]);
    }

    public function show($slug)
    {
        $post = Post::with(['category', 'author', 'tags', 'approvedComments'])
            ->published()
            ->where('slug', $slug)
            ->firstOrFail();

        // Increment views
        $post->incrementViews();

        $post->setAppends([]);
        if ($post->category) {
            $post->category->setAppends([]);
        }
        if ($post->author) {
            $post->author->setAppends([]);
        }
        $post->tags->each(function($tag) {
            $tag->setAppends([]);
        });

        return response()->json([
            'success' => true,
            'message' => 'Detail Data Berita/Artikel',
            'data'    => $post
        ]);
    }
}
