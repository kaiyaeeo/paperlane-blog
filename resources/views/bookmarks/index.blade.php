@extends('layouts.paperlane')

@section('title', 'Bookmark Saya — Paperlane')

@section('content')
    <div class="w-full px-6 lg:px-12 py-12">
        <div class="mb-8">
            <h1 class="font-serif text-3xl md:text-4xl text-[#3E2723] mb-2">Bookmark Saya</h1>
            <p class="text-[#3E2723]/70">Tulisan yang kamu simpan untuk dibaca nanti.</p>
        </div>

        @if(session('success'))
            <div class="bg-[#F4C9D6] text-[#3E2723] px-4 py-3 rounded-lg mb-6 text-sm max-w-md">
                {{ session('success') }}
            </div>
        @endif

        @if($bookmarks->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-x-8 gap-y-10">
                @foreach($bookmarks as $bookmark)
                    @if($bookmark->post)
                        <article class="flex flex-col">
                            @if($bookmark->post->category)
                                <a href="{{ route('blog.category', $bookmark->post->category) }}" class="text-xs text-[#3E2723]/60 uppercase tracking-widest hover:text-[#3E2723] transition">
                                    {{ $bookmark->post->category->name }}
                                </a>
                            @endif
                            <h2 class="font-serif text-xl md:text-2xl text-[#3E2723] mt-2 mb-2 leading-snug">
                                <a href="{{ route('blog.show', $bookmark->post) }}" class="hover:text-[#3E2723]/70 transition">
                                    {{ $bookmark->post->title }}
                                </a>
                            </h2>
                            <p class="text-[#3E2723]/75 leading-relaxed mb-3 text-sm flex-1">
                                {{ \Illuminate\Support\Str::limit(strip_tags($bookmark->post->content), 120) }}
                            </p>
                            <div class="flex items-center gap-2 text-xs text-[#3E2723]/60">
                                <span>{{ $bookmark->post->user->name }}</span>
                                <span>&middot;</span>
                                <span>{{ $bookmark->post->created_at->format('d M Y') }}</span>
                            </div>

                            <form action="{{ route('bookmarks.toggle', $bookmark->post) }}" method="POST" class="mt-3">
                                @csrf
                                <button type="submit" class="text-xs text-[#3E2723]/60 hover:text-red-600 transition">
                                    Hapus dari bookmark
                                </button>
                            </form>
                        </article>
                    @endif
                @endforeach
            </div>

            <div class="mt-12">
                {{ $bookmarks->links() }}
            </div>
        @else
            <div class="text-center py-20">
                <p class="font-serif text-xl text-[#3E2723]/50 italic mb-2">Belum ada bookmark.</p>
                <p class="text-[#3E2723]/60 text-sm">
                    Simpan tulisan yang ingin kamu baca nanti dari <a href="{{ route('blog.index') }}" class="underline hover:no-underline text-[#3E2723]">halaman blog</a>.
                </p>
            </div>
        @endif
    </div>
@endsection