@extends('layouts.paperlane')

@section('title', $post->title . ' — Paperlane')

@section('content')
    <div class="w-full px-6 lg:px-12 py-12">
        <article class="max-w-3xl">
            <!-- Back -->
            <a href="{{ route('blog.index') }}" class="text-sm text-[#3E2723]/60 hover:text-[#3E2723] transition inline-block mb-8">
                &larr; Kembali
            </a>

            <!-- Header -->
            @if($post->category)
                <a href="{{ route('blog.category', $post->category) }}" class="text-xs text-[#3E2723]/60 uppercase tracking-widest hover:text-[#3E2723] transition">
                    {{ $post->category->name }}
                </a>
            @endif
            <h1 class="font-serif text-3xl md:text-5xl text-[#3E2723] leading-[1.1] mt-3 mb-4">
                {{ $post->title }}
            </h1>
            <div class="flex items-center gap-2 text-xs text-[#3E2723]/60 mb-6">
                <span>Oleh
                    <a href="{{ route('profile.show', $post->user) }}" class="font-medium text-[#3E2723] hover:underline">
                        {{ $post->user->name }}
                    </a>
                </span>
                <span>&middot;</span>
                <span>{{ $post->created_at->format('d M Y') }}</span>
            </div>

            <!-- Action Bar -->
            <div class="flex items-center gap-4 mb-10 pb-6 border-b border-[#3E2723]/10">
                @auth
                    @php
                        $isLiked = $post->likes->where('user_id', auth()->id())->count() > 0;
                        $isBookmarked = $post->bookmarks->where('user_id', auth()->id())->count() > 0;
                    @endphp

                    <!-- Like Button -->
                    <form action="{{ route('likes.toggle', $post) }}" method="POST">
                        @csrf
                        <button type="submit" class="flex items-center gap-2 text-sm transition {{ $isLiked ? 'text-red-500' : 'text-[#3E2723]/60 hover:text-[#3E2723]' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="{{ $isLiked ? 'currentColor' : 'none' }}" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                            </svg>
                            <span>{{ $post->likes->count() }}</span>
                        </button>
                    </form>

                    <!-- Bookmark Button -->
                    <form action="{{ route('bookmarks.toggle', $post) }}" method="POST">
                        @csrf
                        <button type="submit" class="flex items-center gap-2 text-sm transition {{ $isBookmarked ? 'text-[#3E2723]' : 'text-[#3E2723]/60 hover:text-[#3E2723]' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="{{ $isBookmarked ? 'currentColor' : 'none' }}" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z" />
                            </svg>
                            <span>{{ $isBookmarked ? 'Disimpan' : 'Simpan' }}</span>
                        </button>
                    </form>
                @else
                    <div class="flex items-center gap-4 text-sm text-[#3E2723]/60">
                        <div class="flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                            </svg>
                            <span>{{ $post->likes->count() }}</span>
                        </div>
                        <a href="{{ route('login') }}" class="underline hover:no-underline text-[#3E2723]">
                            Login
                        </a>
                        <span>untuk like & simpan</span>
                    </div>
                @endauth
            </div>

            <!-- Konten -->
            <div class="text-[#3E2723] leading-[1.8] text-base md:text-lg space-y-5">
                {!! nl2br(e($post->content)) !!}
            </div>

            <!-- Tag -->
            @if($post->tags->count() > 0)
                <div class="flex flex-wrap gap-2 mt-10 pt-6 border-t border-[#3E2723]/10">
                    @foreach($post->tags as $tag)
                        <a href="{{ route('blog.tag', $tag) }}" class="text-xs px-3 py-1 rounded-full bg-[#F4C9D6]/60 text-[#3E2723] hover:bg-[#F4C9D6] transition">
                            #{{ $tag->name }}
                        </a>
                    @endforeach
                </div>
            @endif

            <!-- Komentar -->
            <section class="mt-12 pt-10 border-t border-[#3E2723]/10">
                <h2 class="font-serif text-xl md:text-2xl text-[#3E2723] mb-6">
                    Komentar ({{ $post->comments->count() }})
                </h2>

                @if(session('success'))
                    <div class="bg-[#F4C9D6] text-[#3E2723] px-4 py-3 rounded-lg mb-6 text-sm">
                        {{ session('success') }}
                    </div>
                @endif

                <!-- Form Komentar -->
                @auth
                    <form action="{{ route('comments.store', $post) }}" method="POST" class="mb-10">
                        @csrf
                        <div class="mb-3">
                            <textarea name="content" rows="3" 
                                placeholder="Tulis komentar..." 
                                class="w-full border-[#3E2723]/20 rounded-lg shadow-sm focus:border-[#3E2723] focus:ring-[#3E2723] text-sm bg-white text-[#3E2723]">{{ old('content') }}</textarea>
                            @error('content') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                        </div>
                        <button type="submit" class="px-5 py-2 bg-[#3E2723] text-[#F5F0E6] rounded-full hover:bg-[#3E2723]/85 transition text-sm">
                            Kirim Komentar
                        </button>
                    </form>
                @else
                    <div class="mb-10 p-4 border border-[#3E2723]/15 rounded-lg text-sm text-[#3E2723]/75 bg-[#F4C9D6]/30">
                        <a href="{{ route('login') }}" class="text-[#3E2723] underline hover:no-underline">Login</a> untuk menulis komentar.
                    </div>
                @endauth

                <!-- Daftar Komentar -->
                <div class="space-y-5">
                    @forelse($post->comments as $comment)
                        <div class="flex gap-3">
                            <div class="flex-shrink-0">
                                <a href="{{ route('profile.show', $comment->user) }}">
                                    <img src="{{ $comment->user->avatar_url }}" alt="{{ $comment->user->name }}" class="w-9 h-9 rounded-full object-cover">
                                </a>
                            </div>
                            <div class="flex-1">
                                <div class="flex items-baseline gap-2 mb-1">
                                    <a href="{{ route('profile.show', $comment->user) }}" class="font-medium text-[#3E2723] text-sm hover:underline">
                                        {{ $comment->user->name }}
                                    </a>
                                    <span class="text-xs text-[#3E2723]/50">{{ $comment->created_at->diffForHumans() }}</span>
                                </div>
                                <p class="text-[#3E2723]/85 leading-relaxed text-sm">
                                    {{ $comment->content }}
                                </p>

                                @auth
                                    @if($comment->user_id === auth()->id() || $post->user_id === auth()->id())
                                        <form action="{{ route('comments.destroy', $comment) }}" method="POST" class="mt-2" onsubmit="return confirm('Hapus komentar ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-xs text-[#3E2723]/50 hover:text-red-600 transition">
                                                Hapus
                                            </button>
                                        </form>
                                    @endif
                                @endauth
                            </div>
                        </div>
                    @empty
                        <p class="text-[#3E2723]/50 text-sm italic">Belum ada komentar. Jadilah yang pertama!</p>
                    @endforelse
                </div>
            </section>
        </article>

        <!-- Post Terkait -->
        @if($relatedPosts->count() > 0)
            <section class="max-w-3xl mt-12 pt-10 border-t border-[#3E2723]/10">
                <h2 class="font-serif text-xl text-[#3E2723] mb-6">Tulisan Terkait</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @foreach($relatedPosts as $related)
                        <a href="{{ route('blog.show', $related) }}" class="block group">
                            <h3 class="font-serif text-base text-[#3E2723] group-hover:text-[#3E2723]/70 transition mb-1 leading-snug">
                                {{ $related->title }}
                            </h3>
                            <p class="text-xs text-[#3E2723]/50">
                                {{ $related->created_at->format('d M Y') }}
                            </p>
                        </a>
                    @endforeach
                </div>
            </section>
        @endif
    </div>
@endsection