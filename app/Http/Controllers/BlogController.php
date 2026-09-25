<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        $query = Post::with(['user', 'category', 'tags'])
            ->where('status', 'published');

        // Pencarian
        if ($request->filled('q')) {
            $search = $request->q;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%");
            });
        }

        $posts = $query->latest()->paginate(6)->withQueryString();
        $categories = Category::all();
        $tags = Tag::all();

        return view('blog.index', compact('posts', 'categories', 'tags'));
    }

    public function show(Post $post)
    {
        // Hanya tampilkan post yang sudah published
        if ($post->status !== 'published') {
            abort(404);
        }

        $post->load(['user', 'category', 'tags']);
        
        // Post terkait (kategori sama)
        $relatedPosts = Post::where('status', 'published')
            ->where('category_id', $post->category_id)
            ->where('id', '!=', $post->id)
            ->latest()
            ->take(3)
            ->get();

        return view('blog.show', compact('post', 'relatedPosts'));
    }

    public function category(Category $category)
    {
        $posts = Post::with(['user', 'category', 'tags'])
            ->where('status', 'published')
            ->where('category_id', $category->id)
            ->latest()
            ->paginate(6);

        $categories = Category::all();
        $tags = Tag::all();

        return view('blog.index', compact('posts', 'categories', 'tags', 'category'));
    }

    public function tag(Tag $tag)
    {
        $posts = Post::with(['user', 'category', 'tags'])
            ->where('status', 'published')
            ->whereHas('tags', function ($q) use ($tag) {
                $q->where('tags.id', $tag->id);
            })
            ->latest()
            ->paginate(6);

        $categories = Category::all();
        $tags = Tag::all();

        return view('blog.index', compact('posts', 'categories', 'tags', 'tag'));
    }
}