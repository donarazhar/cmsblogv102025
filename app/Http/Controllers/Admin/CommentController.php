<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function index(Request $request)
    {
        $query = Comment::with(['post', 'user', 'parent']);

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('content', 'like', "%{$search}%")
                    ->orWhere('author_name', 'like', "%{$search}%")
                    ->orWhere('author_email', 'like', "%{$search}%")
                    ->orWhereHas('post', function ($q) use ($search) {
                        $q->where('title', 'like', "%{$search}%");
                    });
            });
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by post
        if ($request->filled('post_id')) {
            $query->where('post_id', $request->post_id);
        }

        // Sort
        $sortField = $request->get('sort', 'created_at');
        $sortDirection = $request->get('direction', 'desc');
        $query->orderBy($sortField, $sortDirection);

        $comments = $query->paginate(20)->withQueryString();

        // Stats
        $stats = [
            'total' => Comment::count(),
            'pending' => Comment::pending()->count(),
            'approved' => Comment::approved()->count(),
            'spam' => Comment::where('status', 'spam')->count(),
        ];

        // Posts for filter
        $posts = Post::published()->latest()->limit(50)->get();

        return view('admin.comments.index', compact('comments', 'stats', 'posts'));
    }

    public function show(Comment $comment)
    {
        $comment->load(['post', 'user', 'parent', 'replies.user']);

        return view('admin.comments.show', compact('comment'));
    }

    public function edit(Comment $comment)
    {
        return view('admin.comments.edit', compact('comment'));
    }

    public function update(Request $request, Comment $comment)
    {
        $validated = $request->validate([
            'content' => 'required|string',
            'status' => 'required|in:pending,approved,spam,trash',
            'author_name' => 'nullable|string|max:255',
            'author_email' => 'nullable|email|max:255',
        ]);

        $comment->update($validated);

        return redirect()->route('admin.comments.show', $comment)
            ->with('success', 'Komentar berhasil diperbarui!');
    }

    public function destroy(Comment $comment)
    {
        $comment->delete();

        return redirect()->route('admin.comments.index')
            ->with('success', 'Komentar berhasil dihapus!');
    }

    public function approve(Comment $comment)
    {
        $comment->approve();

        if (request()->expectsJson()) {
            return response()->json(['success' => true, 'message' => 'Komentar disetujui']);
        }

        return back()->with('success', 'Komentar berhasil disetujui!');
    }

    public function spam(Comment $comment)
    {
        $comment->markAsSpam();

        if (request()->expectsJson()) {
            return response()->json(['success' => true, 'message' => 'Komentar ditandai sebagai spam']);
        }

        return back()->with('success', 'Komentar berhasil ditandai sebagai spam!');
    }

    public function trash(Comment $comment)
    {
        $comment->update(['status' => 'trash']);

        if (request()->expectsJson()) {
            return response()->json(['success' => true, 'message' => 'Komentar dipindahkan ke trash']);
        }

        return back()->with('success', 'Komentar berhasil dipindahkan ke trash!');
    }

    public function bulkAction(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:comments,id',
            'action' => 'required|in:approve,spam,trash,delete',
        ]);

        $comments = Comment::whereIn('id', $request->ids);
        $count = $comments->count();

        switch ($request->action) {
            case 'approve':
                $comments->update(['status' => 'approved']);
                $message = "{$count} komentar berhasil disetujui!";
                break;
            case 'spam':
                $comments->update(['status' => 'spam']);
                $message = "{$count} komentar berhasil ditandai sebagai spam!";
                break;
            case 'trash':
                $comments->update(['status' => 'trash']);
                $message = "{$count} komentar berhasil dipindahkan ke trash!";
                break;
            case 'delete':
                $comments->delete();
                $message = "{$count} komentar berhasil dihapus!";
                break;
        }

        return redirect()->route('admin.comments.index')
            ->with('success', $message);
    }

    public function reply(Request $request, Comment $comment)
    {
        $validated = $request->validate([
            'content' => 'required|string',
        ]);

        Comment::create([
            'post_id' => $comment->post_id,
            'user_id' => auth()->id(),
            'parent_id' => $comment->id,
            'content' => $validated['content'],
            'status' => 'approved',
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return back()->with('success', 'Balasan berhasil ditambahkan!');
    }
}
