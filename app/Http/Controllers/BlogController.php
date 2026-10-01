<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        $query = Post::with(['user', 'category', 'tags', 'likes', 'comments'])
            ->where('status', 'published');

        if ($request->filled('q')) {
            $search = $request->q;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%");
            });
        }

        $posts = $query->latest()->paginate(9)->withQueryString();
        $categories = Category::all();
        $tags = Tag::all();

        return view('blog.index', compact('posts', 'categories', 'tags'));
    }

    public function show(Post $post)
    {
        if ($post->status !== 'published') {
            abort(404);
        }

        $post->load(['user', 'category', 'tags', 'likes', 'bookmarks', 'comments.user']);

        $relatedPosts = $this->getRelatedPosts($post, 3);

        return view('blog.show', compact('post', 'relatedPosts'));
    }

    public function category(Category $category)
    {
        $posts = Post::with(['user', 'category', 'tags', 'likes', 'comments'])
            ->where('status', 'published')
            ->where('category_id', $category->id)
            ->latest()
            ->paginate(9);

        $categories = Category::all();
        $tags = Tag::all();

        return view('blog.index', compact('posts', 'categories', 'tags', 'category'));
    }

    public function tag(Tag $tag)
    {
        $posts = Post::with(['user', 'category', 'tags', 'likes', 'comments'])
            ->where('status', 'published')
            ->whereHas('tags', function ($q) use ($tag) {
                $q->where('tags.id', $tag->id);
            })
            ->latest()
            ->paginate(9);

        $categories = Category::all();
        $tags = Tag::all();

        return view('blog.index', compact('posts', 'categories', 'tags', 'tag'));
    }

    /**
     * Related posts dengan scoring:
     * - Shared tag = bobot 10 (paling penting)
     * - Same category = bobot 5
     * - Popularity (likes*2 + comments) = max 20 (tie-breaker)
     */
    private function getRelatedPosts(Post $post, int $limit = 3): Collection
    {
        $tagIds = $post->tags->pluck('id')->all();
        $categoryId = $post->category_id;

        // Ambil kandidat: published, bukan post ini, kategori sama ATAU punya tag yang sama
        $candidates = Post::with(['user', 'category', 'tags', 'likes', 'comments'])
            ->withCount(['likes', 'comments'])
            ->where('status', 'published')
            ->where('id', '!=', $post->id)
            ->where(function ($q) use ($tagIds, $categoryId) {
                if (! empty($tagIds)) {
                    $q->whereHas('tags', function ($qq) use ($tagIds) {
                        $qq->whereIn('tags.id', $tagIds);
                    });
                }
                if ($categoryId) {
                    $q->orWhere('category_id', $categoryId);
                }
            })
            ->get();

        // Kalau tidak ada kandidat sama sekali, fallback ke post terbaru
        if ($candidates->isEmpty()) {
            return Post::with(['user', 'category', 'tags', 'likes', 'comments'])
                ->where('status', 'published')
                ->where('id', '!=', $post->id)
                ->latest()
                ->take($limit)
                ->get();
        }

        // Hitung skor tiap kandidat
        $scored = $candidates->map(function (Post $candidate) use ($tagIds, $categoryId) {
            $sharedTagCount = $candidate->tags->pluck('id')->intersect($tagIds)->count();
            $sameCategory = $candidate->category_id === $categoryId ? 1 : 0;
            $popularity = min(($candidate->likes_count * 2) + $candidate->comments_count, 20);

            return [
                'post' => $candidate,
                'shared_tags' => $sharedTagCount,
                'same_category' => $sameCategory,
                'score' => ($sharedTagCount * 10) + ($sameCategory * 5) + $popularity,
            ];
        });

        return $scored
            ->sort(function ($a, $b) {
                // Skor tinggi dulu
                if ($a['score'] !== $b['score']) {
                    return $b['score'] <=> $a['score'];
                }
                // Kalau skor sama, post lebih baru dulu
                return $b['post']->created_at->timestamp <=> $a['post']->created_at->timestamp;
            })
            ->take($limit)
            ->pluck('post')
            ->values();
    }
}