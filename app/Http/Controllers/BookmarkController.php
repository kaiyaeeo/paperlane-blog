<?php

namespace App\Http\Controllers;

use App\Models\Post;

class BookmarkController extends Controller
{
    public function index()
    {
        $bookmarks = auth()->user()
            ->bookmarks()
            ->with(['post.user', 'post.category'])
            ->latest()
            ->paginate(9);

        return view('bookmarks.index', compact('bookmarks'));
    }

    public function toggle(Post $post)
    {
        $user = auth()->user();

        $existing = $post->bookmarks()->where('user_id', $user->id)->first();

        if ($existing) {
            $existing->delete();
            $message = 'Bookmark dihapus.';
        } else {
            $post->bookmarks()->create(['user_id' => $user->id]);
            $message = 'Post disimpan ke bookmark!';
        }

        return back()->with('success', $message);
    }
}