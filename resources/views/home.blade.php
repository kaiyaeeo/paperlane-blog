@extends('layouts.paperlane')

@section('title', 'Paperlane — Ruang Menulis Digital')

@section('content')
    <!-- Hero -->
    <section class="max-w-5xl mx-auto px-6 lg:px-8 pt-24 pb-20">
        <div class="max-w-3xl">
            <p class="text-sm text-stone-500 tracking-widest uppercase mb-6">
                Ruang menulis digital
            </p>
            <h1 class="font-serif text-5xl md:text-7xl text-stone-900 leading-[1.05] mb-8">
                Tulis. Terbitkan.<br>
                <span class="italic">Bagikan.</span>
            </h1>
            <p class="text-lg text-stone-600 leading-relaxed mb-10 max-w-xl">
                Paperlane adalah tempat sederhana untuk menulis dan membaca. Tanpa gangguan, tanpa iklan, hanya kata-kata.
            </p>

            <div class="flex flex-wrap items-center gap-4">
                @guest
                    <a href="{{ route('register') }}" class="px-6 py-3 bg-stone-900 text-white rounded-full hover:bg-stone-700 transition text-sm font-medium">
                        Mulai Menulis
                    </a>
                    <a href="{{ route('blog.index') }}" class="px-6 py-3 text-stone-700 hover:text-stone-900 transition text-sm font-medium">
                        Baca Blog &rarr;
                    </a>
                @endguest

                @auth
                    <a href="{{ url('/dashboard') }}" class="px-6 py-3 bg-stone-900 text-white rounded-full hover:bg-stone-700 transition text-sm font-medium">
                        Ke Dashboard
                    </a>
                    <a href="{{ route('blog.index') }}" class="px-6 py-3 text-stone-700 hover:text-stone-900 transition text-sm font-medium">
                        Baca Blog &rarr;
                    </a>
                @endauth
            </div>
        </div>
    </section>

    <!-- Tulisan Terbaru -->
    @if($latestPosts->count() > 0)
        <section class="max-w-5xl mx-auto px-6 lg:px-8 py-16 border-t border-stone-200">
            <div class="flex justify-between items-baseline mb-12">
                <h2 class="font-serif text-3xl md:text-4xl text-stone-900">Tulisan Terbaru</h2>
                <a href="{{ route('blog.index') }}" class="text-sm text-stone-600 hover:text-stone-900 transition">
                    Lihat semua &rarr;
                </a>
            </div>

            <div class="space-y-12">
                @foreach($latestPosts as $post)
                    <article class="group">
                        <div class="grid md:grid-cols-[1fr_auto] gap-6 items-start">
                            <div>
                                @if($post->category)
                                    <a href="{{ route('blog.category', $post->category) }}" class="text-xs text-stone-500 uppercase tracking-widest hover:text-stone-900 transition">
                                        {{ $post->category->name }}
                                    </a>
                                @endif
                                <h3 class="font-serif text-2xl md:text-3xl text-stone-900 mt-3 mb-3 leading-tight">
                                    <a href="{{ route('blog.show', $post) }}" class="hover:text-stone-600 transition">
                                        {{ $post->title }}
                                    </a>
                                </h3>
                                <p class="text-stone-600 leading-relaxed mb-4 max-w-2xl">
                                    {{ \Illuminate\Support\Str::limit(strip_tags($post->content), 160) }}
                                </p>
                                <div class="flex items-center gap-3 text-sm text-stone-500">
                                    <span>{{ $post->user->name }}</span>
                                    <span>&middot;</span>
                                    <span>{{ $post->created_at->format('d M Y') }}</span>
                                </div>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
        </section>
    @endif
@endsection