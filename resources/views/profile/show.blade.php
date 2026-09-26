@extends('layouts.paperlane')

@section('title', $user->name . ' — Paperlane')

@section('content')
    <div class="w-full px-6 lg:px-12 py-12">
        <!-- Header Profil -->
        <div class="flex flex-col md:flex-row items-start md:items-center gap-6 mb-12 pb-8 border-b border-[#3E2723]/10">
            <img src="{{ $user->avatar_url }}" alt="{{ $user->name }}" class="w-24 h-24 rounded-full object-cover border-2 border-[#3E2723]/10">

            <div class="flex-1">
                <h1 class="font-serif text-3xl md:text-4xl text-[#3E2723] mb-2">{{ $user->name }}</h1>

                @if($user->bio)
                    <p class="text-[#3E2723]/75 leading-relaxed mb-4 max-w-2xl">{{ $user->bio }}</p>
                @endif

                <!-- Statistik -->
                <div class="flex flex-wrap items-center gap-6 text-sm text-[#3E2723]/70">
                    <div>
                        <span class="font-serif text-xl text-[#3E2723]">{{ $stats['posts'] }}</span>
                        <span class="ml-1">tulisan</span>
                    </div>
                    <div>
                        <span class="font-serif text-xl text-[#3E2723]">{{ $stats['likes'] }}</span>
                        <span class="ml-1">like</span>
                    </div>
                    <div>
                        <span class="font-serif text-xl text-[#3E2723]">{{ $stats['comments'] }}</span>
                        <span class="ml-1">komentar</span>
                    </div>
                </div>

                @auth
                    @if(auth()->id() === $user->id)
                        <div class="mt-4">
                            <a href="{{ route('profile.edit') }}" class="inline-block text-sm px-4 py-2 bg-[#3E2723] text-[#F5F0E6] rounded-full hover:bg-[#3E2723]/85 transition">
                                Edit Profil
                            </a>
                        </div>
                    @endif
                @endauth
            </div>
        </div>

        @if(session('success'))
            <div class="bg-[#F4C9D6] text-[#3E2723] px-4 py-3 rounded-lg mb-6 text-sm max-w-md">
                {{ session('success') }}
            </div>
        @endif

        <!-- Tulisan Author -->
        <div class="mb-8">
            <h2 class="font-serif text-2xl text-[#3E2723]">Tulisan {{ $user->name }}</h2>
        </div>

        @if($posts->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-x-8 gap-y-10">
                @foreach($posts as $post)
                    <article class="flex flex-col">
                        @if($post->category)
                            <a href="{{ route('blog.category', $post->category) }}" class="text-xs text-[#3E2723]/60 uppercase tracking-widest hover:text-[#3E2723] transition">
                                {{ $post->category->name }}
                            </a>
                        @endif
                        <h3 class="font-serif text-xl md:text-2xl text-[#3E2723] mt-2 mb-2 leading-snug">
                            <a href="{{ route('blog.show', $post) }}" class="hover:text-[#3E2723]/70 transition">
                                {{ $post->title }}
                            </a>
                        </h3>
                        <p class="text-[#3E2723]/75 leading-relaxed mb-3 text-sm flex-1">
                            {{ \Illuminate\Support\Str::limit(strip_tags($post->content), 120) }}
                        </p>
                        <div class="flex items-center gap-2 text-xs text-[#3E2723]/60">
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
                    </article>
                @endforeach
            </div>

            <div class="mt-12">
                {{ $posts->links() }}
            </div>
        @else
            <div class="text-center py-20">
                <p class="font-serif text-xl text-[#3E2723]/50 italic">Belum ada tulisan yang diterbitkan.</p>
            </div>
        @endif
    </div>
@endsection