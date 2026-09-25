@extends('layouts.paperlane')

@section('title', isset($category) ? $category->name . ' — Paperlane' : (isset($tag) ? '#' . $tag->name . ' — Paperlane' : 'Blog — Paperlane'))

@section('content')
    <div class="w-full px-6 lg:px-12 py-12">
        <!-- Header -->
        <div class="mb-8">
            @if(isset($category))
                <p class="text-xs text-[#204654]/60 uppercase tracking-widest mb-2">Kategori</p>
                <h1 class="font-serif text-3xl md:text-4xl text-[#204654]">{{ $category->name }}</h1>
            @elseif(isset($tag))
                <p class="text-xs text-[#204654]/60 uppercase tracking-widest mb-2">Tag</p>
                <h1 class="font-serif text-3xl md:text-4xl text-[#204654]">#{{ $tag->name }}</h1>
            @else
                <h1 class="font-serif text-3xl md:text-4xl text-[#204654] mb-2">Blog</h1>
                <p class="text-[#204654]/70">Semua tulisan yang diterbitkan di Paperlane.</p>
            @endif
        </div>

        <!-- Search -->
        <form method="GET" action="{{ route('blog.index') }}" class="mb-8 max-w-md">
            <div class="flex items-center border-b border-[#204654]/20 focus-within:border-[#204654] transition">
                <input type="text" name="q" value="{{ request('q') }}" 
                    placeholder="Cari tulisan..." 
                    class="flex-1 bg-transparent border-0 px-0 py-2 text-base placeholder-[#204654]/40 focus:ring-0 focus:outline-none text-[#204654]">
                <button type="submit" class="text-sm text-[#204654]/70 hover:text-[#204654] transition px-2">
                    Cari
                </button>
            </div>
        </form>

        <!-- Filter -->
        @if($categories->count() > 0 || $tags->count() > 0)
            <div class="mb-10 pb-6 border-b border-[#204654]/10 space-y-3">
                @if($categories->count() > 0)
                    <div class="flex flex-wrap items-center gap-3">
                        <span class="text-xs text-[#204654]/50 uppercase tracking-widest">Kategori</span>
                        <a href="{{ route('blog.index') }}" class="text-sm {{ !isset($category) && !isset($tag) ? 'text-[#204654] font-medium' : 'text-[#204654]/60 hover:text-[#204654]' }} transition">Semua</a>
                        @foreach($categories as $cat)
                            <a href="{{ route('blog.category', $cat) }}" class="text-sm {{ isset($category) && $category->id === $cat->id ? 'text-[#204654] font-medium' : 'text-[#204654]/60 hover:text-[#204654]' }} transition">
                                {{ $cat->name }}
                            </a>
                        @endforeach
                    </div>
                @endif

                @if($tags->count() > 0)
                    <div class="flex flex-wrap items-center gap-2">
                        <span class="text-xs text-[#204654]/50 uppercase tracking-widest mr-1">Tag</span>
                        @foreach($tags as $t)
                            <a href="{{ route('blog.tag', $t) }}" class="text-xs px-3 py-1 rounded-full transition {{ isset($tag) && $tag->id === $t->id ? 'bg-[#204654] text-[#F7F9E1]' : 'bg-[#CAFFA6]/60 text-[#204654] hover:bg-[#CAFFA6]' }}">
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
                            <a href="{{ route('blog.category', $post->category) }}" class="text-xs text-[#204654]/60 uppercase tracking-widest hover:text-[#204654] transition">
                                {{ $post->category->name }}
                            </a>
                        @endif
                        <h2 class="font-serif text-xl md:text-2xl text-[#204654] mt-2 mb-2 leading-snug">
                            <a href="{{ route('blog.show', $post) }}" class="hover:text-[#204654]/70 transition">
                                {{ $post->title }}
                            </a>
                        </h2>
                        <p class="text-[#204654]/75 leading-relaxed mb-3 text-sm flex-1">
                            {{ \Illuminate\Support\Str::limit(strip_tags($post->content), 120) }}
                        </p>
                        <div class="flex flex-wrap items-center gap-2 text-xs text-[#204654]/60">
                            <span>{{ $post->user->name }}</span>
                            <span>&middot;</span>
                            <span>{{ $post->created_at->format('d M Y') }}</span>
                        </div>
                        @if($post->tags->count() > 0)
                            <div class="flex flex-wrap gap-1 mt-3">
                                @foreach($post->tags->take(3) as $t)
                                    <a href="{{ route('blog.tag', $t) }}" class="text-xs px-2 py-0.5 rounded-full bg-[#CAFFA6]/60 text-[#204654] hover:bg-[#CAFFA6] transition">
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
                <p class="font-serif text-xl text-[#204654]/50 italic mb-2">Tidak ada tulisan.</p>
                <p class="text-[#204654]/60 text-sm">Coba kata kunci lain atau jelajahi kategori lain.</p>
            </div>
        @endif
    </div>
@endsection