@extends('layouts.paperlane')

@section('title', 'Paperlane — Ruang Menulis Digital')

@section('content')
    <!-- Hero -->
    <section class="w-full px-6 lg:px-12 pt-16 pb-12">
        <div class="max-w-3xl">
            <p class="text-xs text-[#204654]/60 tracking-widest uppercase mb-4">
                Ruang menulis digital
            </p>
            <h1 class="font-serif text-4xl md:text-6xl text-[#204654] leading-[1.05] mb-5">
                Tulis. Terbitkan.<br>
                <span class="italic">Bagikan.</span>
            </h1>
            <p class="text-base md:text-lg text-[#204654]/75 leading-relaxed mb-8 max-w-xl">
                Paperlane adalah tempat sederhana untuk menulis dan membaca. Tanpa gangguan, tanpa iklan, hanya kata-kata.
            </p>

            <div class="flex flex-wrap items-center gap-3">
                @guest
                    <a href="{{ route('register') }}" class="px-5 py-2.5 bg-[#204654] text-[#F7F9E1] rounded-full hover:bg-[#204654]/85 transition text-sm font-medium">
                        Mulai Menulis
                    </a>
                    <a href="{{ route('blog.index') }}" class="px-5 py-2.5 bg-[#CAFFA6] text-[#204654] rounded-full hover:bg-[#CAFFA6]/80 transition text-sm font-medium">
                        Baca Blog &rarr;
                    </a>
                @endguest

                @auth
                    <a href="{{ url('/dashboard') }}" class="px-5 py-2.5 bg-[#204654] text-[#F7F9E1] rounded-full hover:bg-[#204654]/85 transition text-sm font-medium">
                        Ke Dashboard
                    </a>
                    <a href="{{ route('blog.index') }}" class="px-5 py-2.5 bg-[#CAFFA6] text-[#204654] rounded-full hover:bg-[#CAFFA6]/80 transition text-sm font-medium">
                        Baca Blog &rarr;
                    </a>
                @endauth
            </div>
        </div>
    </section>

    <!-- Tulisan Terbaru -->
    @if($latestPosts->count() > 0)
        <section class="w-full px-6 lg:px-12 py-12 border-t border-[#204654]/10">
            <div class="flex justify-between items-baseline mb-8">
                <h2 class="font-serif text-2xl md:text-3xl text-[#204654]">Tulisan Terbaru</h2>
                <a href="{{ route('blog.index') }}" class="text-sm text-[#204654]/70 hover:text-[#204654] transition">
                    Lihat semua &rarr;
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-x-8 gap-y-10">
                @foreach($latestPosts as $post)
                    <article class="flex flex-col">
                        @if($post->category)
                            <a href="{{ route('blog.category', $post->category) }}" class="text-xs text-[#204654]/60 uppercase tracking-widest hover:text-[#204654] transition">
                                {{ $post->category->name }}
                            </a>
                        @endif
                        <h3 class="font-serif text-xl md:text-2xl text-[#204654] mt-2 mb-2 leading-snug">
                            <a href="{{ route('blog.show', $post) }}" class="hover:text-[#204654]/70 transition">
                                {{ $post->title }}
                            </a>
                        </h3>
                        <p class="text-[#204654]/75 leading-relaxed mb-3 text-sm flex-1">
                            {{ \Illuminate\Support\Str::limit(strip_tags($post->content), 120) }}
                        </p>
                        <div class="flex items-center gap-2 text-xs text-[#204654]/60">
                            <span>{{ $post->user->name }}</span>
                            <span>&middot;</span>
                            <span>{{ $post->created_at->format('d M Y') }}</span>
                        </div>
                        <div class="flex items-center gap-3 text-xs text-[#204654]/60 mt-2">
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
                    </article>
                @endforeach
            </div>
        </section>
    @endif
@endsection