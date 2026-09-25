@extends('layouts.paperlane')

@section('title', $post->title . ' — Paperlane')

@section('content')
    <div class="w-full px-6 lg:px-12 py-12">
        <article class="max-w-3xl">
            <!-- Back -->
            <a href="{{ route('blog.index') }}" class="text-sm text-[#204654]/60 hover:text-[#204654] transition inline-block mb-8">
                &larr; Kembali
            </a>

            <!-- Header -->
            @if($post->category)
                <a href="{{ route('blog.category', $post->category) }}" class="text-xs text-[#204654]/60 uppercase tracking-widest hover:text-[#204654] transition">
                    {{ $post->category->name }}
                </a>
            @endif
            <h1 class="font-serif text-3xl md:text-5xl text-[#204654] leading-[1.1] mt-3 mb-4">
                {{ $post->title }}
            </h1>
            <div class="flex items-center gap-2 text-xs text-[#204654]/60 mb-10">
                <span>Oleh <strong class="text-[#204654]">{{ $post->user->name }}</strong></span>
                <span>&middot;</span>
                <span>{{ $post->created_at->format('d M Y') }}</span>
            </div>

            <!-- Konten -->
            <div class="text-[#204654] leading-[1.8] text-base md:text-lg space-y-5">
                {!! nl2br(e($post->content)) !!}
            </div>

            <!-- Tag -->
            @if($post->tags->count() > 0)
                <div class="flex flex-wrap gap-2 mt-10 pt-6 border-t border-[#204654]/10">
                    @foreach($post->tags as $tag)
                        <a href="{{ route('blog.tag', $tag) }}" class="text-xs px-3 py-1 rounded-full bg-[#CAFFA6]/60 text-[#204654] hover:bg-[#CAFFA6] transition">
                            #{{ $tag->name }}
                        </a>
                    @endforeach
                </div>
            @endif

            <!-- Komentar -->
            <section class="mt-12 pt-10 border-t border-[#204654]/10">
                <h2 class="font-serif text-xl md:text-2xl text-[#204654] mb-6">
                    Komentar ({{ $post->comments->count() }})
                </h2>

                @if(session('success'))
                    <div class="bg-[#CAFFA6] text-[#204654] px-4 py-3 rounded-lg mb-6 text-sm">
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
                                class="w-full border-[#204654]/20 rounded-lg shadow-sm focus:border-[#204654] focus:ring-[#204654] text-sm bg-white text-[#204654]">{{ old('content') }}</textarea>
                            @error('content') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                        </div>
                        <button type="submit" class="px-5 py-2 bg-[#204654] text-[#F7F9E1] rounded-full hover:bg-[#204654]/85 transition text-sm">
                            Kirim Komentar
                        </button>
                    </form>
                @else
                    <div class="mb-10 p-4 border border-[#204654]/15 rounded-lg text-sm text-[#204654]/75 bg-[#A9E0F1]/30">
                        <a href="{{ route('login') }}" class="text-[#204654] underline hover:no-underline">Login</a> untuk menulis komentar.
                    </div>
                @endauth

                <!-- Daftar Komentar -->
                <div class="space-y-5">
                    @forelse($post->comments as $comment)
                        <div class="flex gap-3">
                            <div class="flex-shrink-0">
                                <div class="w-9 h-9 rounded-full bg-[#A9E0F1] flex items-center justify-center text-[#204654] font-medium text-sm">
                                    {{ strtoupper(substr($comment->user->name, 0, 1)) }}
                                </div>
                            </div>
                            <div class="flex-1">
                                <div class="flex items-baseline gap-2 mb-1">
                                    <span class="font-medium text-[#204654] text-sm">{{ $comment->user->name }}</span>
                                    <span class="text-xs text-[#204654]/50">{{ $comment->created_at->diffForHumans() }}</span>
                                </div>
                                <p class="text-[#204654]/85 leading-relaxed text-sm">
                                    {{ $comment->content }}
                                </p>

                                @auth
                                    @if($comment->user_id === auth()->id() || $post->user_id === auth()->id())
                                        <form action="{{ route('comments.destroy', $comment) }}" method="POST" class="mt-2" onsubmit="return confirm('Hapus komentar ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-xs text-[#204654]/50 hover:text-red-600 transition">
                                                Hapus
                                            </button>
                                        </form>
                                    @endif
                                @endauth
                            </div>
                        </div>
                    @empty
                        <p class="text-[#204654]/50 text-sm italic">Belum ada komentar. Jadilah yang pertama!</p>
                    @endforelse
                </div>
            </section>
        </article>

        <!-- Post Terkait -->
        @if($relatedPosts->count() > 0)
            <section class="max-w-3xl mt-12 pt-10 border-t border-[#204654]/10">
                <h2 class="font-serif text-xl text-[#204654] mb-6">Tulisan Terkait</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @foreach($relatedPosts as $related)
                        <a href="{{ route('blog.show', $related) }}" class="block group">
                            <h3 class="font-serif text-base text-[#204654] group-hover:text-[#204654]/70 transition mb-1 leading-snug">
                                {{ $related->title }}
                            </h3>
                            <p class="text-xs text-[#204654]/50">
                                {{ $related->created_at->format('d M Y') }}
                            </p>
                        </a>
                    @endforeach
                </div>
            </section>
        @endif
    </div>
@endsection