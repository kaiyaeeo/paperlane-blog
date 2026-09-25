@extends('layouts.paperlane')

@section('title', isset($category) ? $category->name . ' — Paperlane' : (isset($tag) ? '#' . $tag->name . ' — Paperlane' : 'Blog — Paperlane'))

@section('content')
    <div class="max-w-5xl mx-auto px-6 lg:px-8 py-16">
        <!-- Header -->
        <div class="mb-12">
            @if(isset($category))
                <p class="text-sm text-stone-500 uppercase tracking-widest mb-3">Kategori</p>
                <h1 class="font-serif text-5xl text-stone-900">{{ $category->name }}</h1>
            @elseif(isset($tag))
                <p class="text-sm text-stone-500 uppercase tracking-widest mb-3">Tag</p>
                <h1 class="font-serif text-5xl text-stone-900">#{{ $tag->name }}</h1>
            @else
                <h1 class="font-serif text-5xl md:text-6xl text-stone-900 mb-4">Blog</h1>
                <p class="text-stone-600 text-lg">Semua tulisan yang diterbitkan di Paperlane.</p>
            @endif
        </div>

        <!-- Search -->
        <form method="GET" action="{{ route('blog.index') }}" class="mb-12">
            <div class="flex items-center border-b border-stone-300 focus-within:border-stone-900 transition">
                <input type="text" name="q" value="{{ request('q') }}" 
                    placeholder="Cari tulisan..." 
                    class="flex-1 bg-transparent border-0 px-0 py-3 text-lg placeholder-stone-400 focus:ring-0 focus:outline-none">
                <button type="submit" class="text-sm text-stone-600 hover:text-stone-900 transition px-2">
                    Cari
                </button>
            </div>
        </form>

        <!-- Filter -->
        @if($categories->count() > 0 || $tags->count() > 0)
            <div class="mb-12 pb-8 border-b border-stone-200">
                @if($categories->count() > 0)
                    <div class="flex flex-wrap items-center gap-3 mb-4">
                        <span class="text-xs text-stone-500 uppercase tracking-widest">Kategori</span>
                        <a href="{{ route('blog.index') }}" class="text-sm {{ !isset($category) && !isset($tag) ? 'text-stone-900 font-medium' : 'text-stone-600 hover:text-stone-900' }} transition">Semua</a>
                        @foreach($categories as $cat)
                            <a href="{{ route('blog.category', $cat) }}" class="text-sm {{ isset($category) && $category->id === $cat->id ? 'text-stone-900 font-medium' : 'text-stone-600 hover:text-stone-900' }} transition">
                                {{ $cat->name }}
                            </a>
                        @endforeach
                    </div>
                @endif

                @if($tags->count() > 0)
                    <div class="flex flex-wrap items-center gap-2">
                        <span class="text-xs text-stone-500 uppercase tracking-widest mr-1">Tag</span>
                        @foreach($tags as $t)
                            <a href="{{ route('blog.tag', $t) }}" class="text-xs px-3 py-1 rounded-full border {{ isset($tag) && $tag->id === $t->id ? 'bg-stone-900 text-white border-stone-900' : 'border-stone-300 text-stone-600 hover:border-stone-900 hover:text-stone-900' }} transition">
                                #{{ $t->name }}
                            </a>
                        @endforeach
                    </div>
                @endif
            </div>
        @endif

        <!-- Daftar Post -->
        @if($posts->count() > 0)
            <div class="space-y-14">
                @foreach($posts as $post)
                    <article>
                        @if($post->category)
                            <a href="{{ route('blog.category', $post->category) }}" class="text-xs text-stone-500 uppercase tracking-widest hover:text-stone-900 transition">
                                {{ $post->category->name }}
                            </a>
                        @endif
                        <h2 class="font-serif text-3xl text-stone-900 mt-3 mb-3 leading-tight">
                            <a href="{{ route('blog.show', $post) }}" class="hover:text-stone-600 transition">
                                {{ $post->title }}
                            </a>
                        </h2>
                        <p class="text-stone-600 leading-relaxed mb-4">
                            {{ \Illuminate\Support\Str::limit(strip_tags($post->content), 180) }}
                        </p>
                        <div class="flex items-center gap-3 text-sm text-stone-500">
                            <span>{{ $post->user->name }}</span>
                            <span>&middot;</span>
                            <span>{{ $post->created_at->format('d M Y') }}</span>
                            @if($post->tags->count() > 0)
                                <span>&middot;</span>
                                <div class="flex gap-1">
                                    @foreach($post->tags->take(3) as $t)
                                        <a href="{{ route('blog.tag', $t) }}" class="hover:text-stone-900 transition">#{{ $t->name }}</a>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </article>
                @endforeach
            </div>

            <div class="mt-16">
                {{ $posts->links() }}
            </div>
        @else
            <div class="text-center py-20">
                <p class="font-serif text-2xl text-stone-400 italic mb-2">Tidak ada tulisan.</p>
                <p class="text-stone-500 text-sm">Coba kata kunci lain atau jelajahi kategori lain.</p>
            </div>
        @endif
    </div>
@endsection