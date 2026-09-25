<?php

namespace App\Http\Controllers;

use App\Models\Post;

class LikeController extends Controller
{
    public function toggle(Post $post)
    {
        $user = auth()->user();

        $existing = $post->likes()->where('user_id', $user->id)->first();

        if ($existing) {
            $existing->delete();
            $message = 'Like dihapus.';
        } else {
            $post->likes()->create(['user_id' => $user->id]);
            $message = 'Post disukai!';
        }

        return back()->with('success', $message);
    }
}