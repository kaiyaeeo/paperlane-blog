@extends('layouts.paperlane')

@section('title', $post->title . ' — Paperlane')

@section('content')
    <div class="w-full px-6 lg:px-12 py-12">
        <article class="max-w-3xl">
            <!-- Back -->
            <a href="{{ route('blog.index') }}" class="text-sm text-ink/60 hover:text-ink transition inline-block mb-8">
                &larr; Kembali
            </a>

            <!-- Header -->
            @if($post->category)
                <a href="{{ route('blog.category', $post->category) }}" class="text-xs text-ink/60 uppercase tracking-widest hover:text-ink transition">
                    {{ $post->category->name }}
                </a>
            @endif
            <h1 class="font-serif text-3xl md:text-5xl text-ink leading-[1.1] mt-3 mb-4">
                {{ $post->title }}
            </h1>
            <div class="flex items-center gap-2 text-xs text-ink/60 mb-6">
                <span>Oleh
                    <a href="{{ route('profile.show', $post->user) }}" class="font-medium text-ink hover:underline">
                        {{ $post->user->name }}
                    </a>
                </span>
                <span>&middot;</span>
                <span>{{ $post->created_at->format('d M Y') }}</span>
            </div>

            <!-- Action Bar -->
            <div class="flex items-center gap-4 mb-10 pb-6 border-b border-ink/10">
                @auth
                    @php
                        $isLiked = $post->likes->where('user_id', auth()->id())->count() > 0;
                        $isBookmarked = $post->bookmarks->where('user_id', auth()->id())->count() > 0;
                    @endphp

                    <form action="{{ route('likes.toggle', $post) }}" method="POST">
                        @csrf
                        <button type="submit" class="flex items-center gap-2 text-sm transition {{ $isLiked ? 'text-red-500' : 'text-ink/60 hover:text-ink' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="{{ $isLiked ? 'currentColor' : 'none' }}" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                            </svg>
                            <span>{{ $post->likes->count() }}</span>
                        </button>
                    </form>

                    <form action="{{ route('bookmarks.toggle', $post) }}" method="POST">
                        @csrf
                        <button type="submit" class="flex items-center gap-2 text-sm transition {{ $isBookmarked ? 'text-ink' : 'text-ink/60 hover:text-ink' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="{{ $isBookmarked ? 'currentColor' : 'none' }}" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z" />
                            </svg>
                            <span>{{ $isBookmarked ? 'Disimpan' : 'Simpan' }}</span>
                        </button>
                    </form>
                @else
                    <div class="flex items-center gap-4 text-sm text-ink/60">
                        <div class="flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                            </svg>
                            <span>{{ $post->likes->count() }}</span>
                        </div>
                        <a href="{{ route('login') }}" class="underline hover:no-underline text-ink">
                            Login
                        </a>
                        <span>untuk like & simpan</span>
                    </div>
                @endauth
            </div>

            <!-- Konten -->
            <div class="prose-paperlane text-ink leading-[1.8] text-base md:text-lg">
                {!! $post->content !!}
            </div>

            <!-- Tag -->
            @if($post->tags->count() > 0)
                <div class="flex flex-wrap gap-2 mt-10 pt-6 border-t border-ink/10">
                    @foreach($post->tags as $tag)
                        <a href="{{ route('blog.tag', $tag) }}" class="text-xs px-3 py-1 rounded-full bg-accent/60 text-ink hover:bg-accent transition">
                            #{{ $tag->name }}
                        </a>
                    @endforeach
                </div>
            @endif

            <!-- Komentar -->
            <section class="mt-12 pt-10 border-t border-ink/10">
                <h2 class="font-serif text-xl md:text-2xl text-ink mb-6">
                    Komentar ({{ $post->comments->count() }})
                </h2>

                @if(session('success'))
                    <div class="bg-accent text-ink px-4 py-3 rounded-lg mb-6 text-sm">
                        {{ session('success') }}
                    </div>
                @endif

                @auth
                    <form action="{{ route('comments.store', $post) }}" method="POST" class="mb-10">
                        @csrf
                        <div class="mb-3">
                            <textarea name="content" rows="3" 
                                placeholder="Tulis komentar..." 
                                class="w-full border-ink/20 rounded-lg shadow-sm focus:border-ink focus:ring-[#3E2723] text-sm bg-surface text-ink">{{ old('content') }}</textarea>
                            @error('content') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                        </div>
                        <button type="submit" class="px-5 py-2 bg-ink text-paper rounded-full hover:bg-ink/85 transition text-sm">
                            Kirim Komentar
                        </button>
                    </form>
                @else
                    <div class="mb-10 p-4 border border-ink/15 rounded-lg text-sm text-ink/75 bg-accent/30">
                        <a href="{{ route('login') }}" class="text-ink underline hover:no-underline">Login</a> untuk menulis komentar.
                    </div>
                @endauth

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
                                    <a href="{{ route('profile.show', $comment->user) }}" class="font-medium text-ink text-sm hover:underline">
                                        {{ $comment->user->name }}
                                    </a>
                                    <span class="text-xs text-ink/50">{{ $comment->created_at->diffForHumans() }}</span>
                                </div>
                                <p class="text-ink/85 leading-relaxed text-sm">
                                    {{ $comment->content }}
                                </p>

                                @auth
                                    @if($comment->user_id === auth()->id() || $post->user_id === auth()->id() || auth()->user()->isAdmin())
                                        <form action="{{ route('comments.destroy', $comment) }}" method="POST" class="mt-2" onsubmit="return confirm('Hapus komentar ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-xs text-ink/50 hover:text-red-600 transition">
                                                Hapus
                                            </button>
                                        </form>
                                    @endif
                                @endauth
                            </div>
                        </div>
                    @empty
                        <p class="text-ink/50 text-sm italic">Belum ada komentar. Jadilah yang pertama!</p>
                    @endforelse
                </div>
            </section>
        </article>

        @if($relatedPosts->count() > 0)
            <section class="max-w-3xl mt-12 pt-10 border-t border-ink/10">
                <div class="flex items-baseline justify-between mb-6">
                    <h2 class="font-serif text-xl text-ink">Tulisan Terkait</h2>
                    <span class="text-xs text-ink/40 uppercase tracking-widest">Pilihan untukmu</span>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @foreach($relatedPosts as $related)
                        @php
                            // Hitung tag yang sama untuk indikator
                            $currentTagIds = $post->tags->pluck('id')->all();
                            $sharedTags = $related->tags->whereIn('id', $currentTagIds);
                        @endphp
                        <a href="{{ route('blog.show', $related) }}" class="block group">
                            @if($related->category)
                                <span class="text-xs text-ink/50 uppercase tracking-widest">
                                    {{ $related->category->name }}
                                </span>
                            @endif
                            <h3 class="font-serif text-lg text-ink group-hover:text-ink/70 transition mt-1 mb-2 leading-snug">
                                {{ $related->title }}
                            </h3>

                            {{-- Indikator kenapa post ini terkait --}}
                            @if($sharedTags->count() > 0)
                                <div class="flex flex-wrap gap-1 mb-2">
                                    @foreach($sharedTags->take(2) as $t)
                                        <span class="text-[10px] px-2 py-0.5 rounded-full bg-accent/60 text-ink">
                                            #{{ $t->name }}
                                        </span>
                                    @endforeach
                                </div>
                            @else
                                <p class="text-xs text-ink/50 mb-2">
                                    Kategori sama
                                </p>
                            @endif

                            <div class="flex items-center gap-3 text-xs text-ink/40">
                                <span>{{ $related->created_at->format('d M Y') }}</span>
                                <span>&middot;</span>
                                <span class="flex items-center gap-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                    </svg>
                                    {{ $related->likes->count() }}
                                </span>
                            </div>
                        </a>
                    @endforeach
                </div>
            </section>
        @endif
    </div>
@endsection