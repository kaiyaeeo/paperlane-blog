<?php

namespace App\Http\Controllers;

use App\Models\Post;

class HomeController extends Controller
{
    public function index()
    {
        $latestPosts = Post::with(['user', 'category', 'tags'])
            ->where('status', 'published')
            ->latest()
            ->take(6)
            ->get();

        return view('home', compact('latestPosts'));
    }
}