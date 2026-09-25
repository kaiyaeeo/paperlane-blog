@extends('layouts.paperlane')

@section('title', 'Beranda - Paperlane')

@section('content')
    <div class="max-w-5xl mx-auto px-4 py-16">
        <!-- Hero -->
        <div class="text-center mb-16">
            <h1 class="text-4xl font-bold text-gray-900 mb-4">
                Selamat Datang di Paperlane
            </h1>
            <p class="text-lg text-gray-600 mb-8">
                Ruang menulis digital. Tempat kamu menulis, menerbitkan, dan membaca tulisan.
            </p>

            @guest
                <div class="space-x-4">
                    <a href="{{ route('register') }}" class="inline-block px-6 py-3 bg-gray-900 text-white rounded-lg hover:bg-gray-700 transition">
                        Mulai Menulis
                    </a>
                    <a href="{{ route('blog.index') }}" class="inline-block px-6 py-3 border border-gray-300 rounded-lg hover:bg-gray-100 transition">
                        Baca Blog
                    </a>
                </div>
            @endguest

            @auth
                <div class="space-x-4">
                    <a href="{{ url('/dashboard') }}" class="inline-block px-6 py-3 bg-gray-900 text-white rounded-lg hover:bg-gray-700 transition">
                        Ke Dashboard
                    </a>
                    <a href="{{ route('blog.index') }}" class="inline-block px-6 py-3 border border-gray-300 rounded-lg hover:bg-gray-100 transition">
                        Baca Blog
                    </a>
                </div>
            @endauth
        </div>

        <!-- Post Terbaru -->
        @if($latestPosts->count() > 0)
            <div>
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold">Tulisan Terbaru</h2>
                    <a href="{{ route('blog.index') }}" class="text-sm text-blue-600 hover:text-blue-800">Lihat Semua &rarr;</a>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($latestPosts as $post)
                        <article class="bg-white p-6 rounded-lg shadow-sm border border-gray-100 hover:shadow-md transition">
                            @if($post->category)
                                <span class="text-xs text-gray-500 uppercase tracking-wide">{{ $post->category->name }}</span>
                            @endif
                            <h3 class="text-lg font-semibold mt-2 mb-2">
                                <a href="{{ route('blog.show', $post) }}" class="hover:text-blue-600">
                                    {{ $post->title }}
                                </a>
                            </h3>
                            <p class="text-sm text-gray-600 mb-4">
                                {{ \Illuminate\Support\Str::limit(strip_tags($post->content), 100) }}
                            </p>
                            <div class="text-xs text-gray-400">
                                Oleh {{ $post->user->name }} &middot; {{ $post->created_at->diffForHumans() }}
                            </div>
                        </article>
                    @endforeach
                </div>
            </div>
        @else
            <div class="text-center text-gray-500 py-12">
                Belum ada tulisan yang diterbitkan.
            </div>
        @endif
    </div>
@endsection