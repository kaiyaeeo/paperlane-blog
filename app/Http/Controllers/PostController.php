<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::where('user_id', auth()->id())->latest()->paginate(10);
        return view('posts.index', compact('posts'));
    }

    public function create()
    {
        return view('posts.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'status' => 'required|in:draft,published',
        ]);

        $validated['user_id'] = auth()->id();
        $validated['slug'] = Str::slug($request->title) . '-' . Str::random(5);

        Post::create($validated);

        return redirect()->route('posts.index')->with('success', 'Post berhasil dibuat!');
    }

    // Method lain (show, edit, update, destroy) biarkan dulu kosong
    public function show(Post $post) {}
    public function edit(Post $post) {}
    public function update(Request $request, Post $post) {}
    public function destroy(Post $post) {}
}