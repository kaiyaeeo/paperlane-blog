@extends('layouts.paperlane')

@section('title', isset($category) ? $category->name . ' — Paperlane' : (isset($tag) ? '#' . $tag->name . ' — Paperlane' : 'Blog — Paperlane'))

@section('content')
    <div class="w-full px-6 lg:px-12 py-12">
        <!-- Header -->
        <div class="mb-8">
            @if(isset($category))
                <p class="text-xs text-[#3E2723]/60 uppercase tracking-widest mb-2">Kategori</p>
                <h1 class="font-serif text-3xl md:text-4xl text-[#3E2723]">{{ $category->name }}</h1>
            @elseif(isset($tag))
                <p class="text-xs text-[#3E2723]/60 uppercase tracking-widest mb-2">Tag</p>
                <h1 class="font-serif text-3xl md:text-4xl text-[#3E2723]">#{{ $tag->name }}</h1>
            @else
                <h1 class="font-serif text-3xl md:text-4xl text-[#3E2723] mb-2">Blog</h1>
                <p class="text-[#3E2723]/70">Semua tulisan yang diterbitkan di Paperlane.</p>
            @endif
        </div>

        <!-- Search -->
        <form method="GET" action="{{ route('blog.index') }}" class="mb-8 max-w-md">
            <div class="flex items-center border-b border-[#3E2723]/20 focus-within:border-[#3E2723] transition">
                <input type="text" name="q" value="{{ request('q') }}" 
                    placeholder="Cari tulisan..." 
                    class="flex-1 bg-transparent border-0 px-0 py-2 text-base placeholder-[#3E2723]/40 focus:ring-0 focus:outline-none text-[#3E2723]">
                <button type="submit" class="text-sm text-[#3E2723]/70 hover:text-[#3E2723] transition px-2">
                    Cari
                </button>
            </div>
        </form>

        <!-- Filter -->
        @if($categories->count() > 0 || $tags->count() > 0)
            <div class="mb-10 pb-6 border-b border-[#3E2723]/10 space-y-3">
                @if($categories->count() > 0)
                    <div class="flex flex-wrap items-center gap-3">
                        <span class="text-xs text-[#3E2723]/50 uppercase tracking-widest">Kategori</span>
                        <a href="{{ route('blog.index') }}" class="text-sm {{ !isset($category) && !isset($tag) ? 'text-[#3E2723] font-medium' : 'text-[#3E2723]/60 hover:text-[#3E2723]' }} transition">Semua</a>
                        @foreach($categories as $cat)
                            <a href="{{ route('blog.category', $cat) }}" class="text-sm {{ isset($category) && $category->id === $cat->id ? 'text-[#3E2723] font-medium' : 'text-[#3E2723]/60 hover:text-[#3E2723]' }} transition">
                                {{ $cat->name }}
                            </a>
                        @endforeach
                    </div>
                @endif

                @if($tags->count() > 0)
                    <div class="flex flex-wrap items-center gap-2">
                        <span class="text-xs text-[#3E2723]/50 uppercase tracking-widest mr-1">Tag</span>
                        @foreach($tags as $t)
                            <a href="{{ route('blog.tag', $t) }}" class="text-xs px-3 py-1 rounded-full transition {{ isset($tag) && $tag->id === $t->id ? 'bg-[#3E2723] text-[#F5F0E6]' : 'bg-[#F4C9D6]/60 text-[#3E2723] hover:bg-[#F4C9D6]' }}">
                                #{{ $t->name }}
                            </a>
                        @endforeach
                    </div>
                @endif
            </div>
        @endif

        <!-- Daftar Post -->
        @if($posts->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-x-8 gap-y-10">
                @foreach($posts as $post)
                    <article class="flex flex-col">
                        @if($post->category)
                            <a href="{{ route('blog.category', $post->category) }}" class="text-xs text-[#3E2723]/60 uppercase tracking-widest hover:text-[#3E2723] transition">
                                {{ $post->category->name }}
                            </a>
                        @endif
                        <h2 class="font-serif text-xl md:text-2xl text-[#3E2723] mt-2 mb-2 leading-snug">
                            <a href="{{ route('blog.show', $post) }}" class="hover:text-[#3E2723]/70 transition">
                                {{ $post->title }}
                            </a>
                        </h2>
                        <p class="text-[#3E2723]/75 leading-relaxed mb-3 text-sm flex-1">
                            {{ \Illuminate\Support\Str::limit(strip_tags($post->content), 120) }}
                        </p>
                        <div class="flex flex-wrap items-center gap-2 text-xs text-[#3E2723]/60">
                            <a href="{{ route('profile.show', $post->user) }}" class="hover:text-[#3E2723] transition">
                                {{ $post->user->name }}
                            </a>
                            <span>&middot;</span>
                            <span>{{ $post->created_at->format('d M Y') }}</span>
                        </div>
                        <div class="flex items-center gap-3 text-xs text-[#3E2723]/60 mt-2">
                            <span class="flex items-center gap-1">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                </svg>
                                {{ $post->likes->count() }}
                            </span>
                            <span class="flex items-center gap-1">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                </svg>
                                {{ $post->comments->count() }}
                            </span>
                        </div>
                        @if($post->tags->count() > 0)
                            <div class="flex flex-wrap gap-1 mt-3">
                                @foreach($post->tags->take(3) as $t)
                                    <a href="{{ route('blog.tag', $t) }}" class="text-xs px-2 py-0.5 rounded-full bg-[#F4C9D6]/60 text-[#3E2723] hover:bg-[#F4C9D6] transition">
                                        #{{ $t->name }}
                                    </a>
                                @endforeach
                            </div>
                        @endif
                    </article>
                @endforeach
            </div>

            <div class="mt-12">
                {{ $posts->links() }}
            </div>
        @else
            <div class="text-center py-20">
                <p class="font-serif text-xl text-[#3E2723]/50 italic mb-2">Tidak ada tulisan.</p>
                <p class="text-[#3E2723]/60 text-sm">Coba kata kunci lain atau jelajahi kategori lain.</p>
            </div>
        @endif
    </div>
@endsection