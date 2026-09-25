@extends('layouts.paperlane')

@section('title', 'Blog - Paperlane')

@section('content')
    <div class="max-w-5xl mx-auto px-4 py-8">
        <!-- Header -->
        <div class="mb-8">
            @if(isset($category))
                <p class="text-sm text-gray-500 mb-1">Kategori</p>
                <h1 class="text-3xl font-bold">{{ $category->name }}</h1>
            @elseif(isset($tag))
                <p class="text-sm text-gray-500 mb-1">Tag</p>
                <h1 class="text-3xl font-bold">#{{ $tag->name }}</h1>
            @else
                <h1 class="text-3xl font-bold">Blog</h1>
                <p class="text-gray-600 mt-1">Semua tulisan yang diterbitkan di Paperlane.</p>
            @endif
        </div>

        <!-- Search -->
        <form method="GET" action="{{ route('blog.index') }}" class="mb-8">
            <div class="flex gap-2">
                <input type="text" name="q" value="{{ request('q') }}" 
                    placeholder="Cari tulisan..." 
                    class="flex-1 border-gray-300 rounded-lg shadow-sm focus:border-gray-500 focus:ring-gray-500">
                <button type="submit" class="px-6 py-2 bg-gray-900 text-white rounded-lg hover:bg-gray-700 transition">
                    Cari
                </button>
            </div>
        </form>

        <!-- Filter -->
        <div class="mb-8 space-y-3">
            <div>
                <span class="text-sm font-medium text-gray-700 mr-2">Kategori:</span>
                <a href="{{ route('blog.index') }}" class="text-sm text-gray-600 hover:text-gray-900 mr-2">Semua</a>
                @foreach($categories as $cat)
                    <a href="{{ route('blog.category', $cat) }}" class="text-sm text-gray-600 hover:text-gray-900 mr-2">
                        {{ $cat->name }}
                    </a>
                @endforeach
            </div>
            <div>
                <span class="text-sm font-medium text-gray-700 mr-2">Tag:</span>
                @foreach($tags as $t)
                    <a href="{{ route('blog.tag', $t) }}" class="text-xs bg-gray-200 text-gray-700 px-2 py-1 rounded-full hover:bg-gray-300 mr-1">
                        #{{ $t->name }}
                    </a>
                @endforeach
            </div>
        </div>

        <!-- Daftar Post -->
        @if($posts->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @foreach($posts as $post)
                    <article class="bg-white p-6 rounded-lg shadow-sm border border-gray-100 hover:shadow-md transition">
                        @if($post->category)
                            <span class="text-xs text-gray-500 uppercase tracking-wide">{{ $post->category->name }}</span>
                        @endif
                        <h2 class="text-xl font-semibold mt-2 mb-2">
                            <a href="{{ route('blog.show', $post) }}" class="hover:text-blue-600">
                                {{ $post->title }}
                            </a>
                        </h2>
                        <p class="text-sm text-gray-600 mb-4">
                            {{ \Illuminate\Support\Str::limit(strip_tags($post->content), 120) }}
                        </p>
                        <div class="flex gap-1 mb-3">
                            @foreach($post->tags as $t)
                                <span class="text-xs bg-gray-100 text-gray-600 px-2 py-1 rounded-full">#{{ $t->name }}</span>
                            @endforeach
                        </div>
                        <div class="text-xs text-gray-400">
                            Oleh {{ $post->user->name }} &middot; {{ $post->created_at->diffForHumans() }}
                        </div>
                    </article>
                @endforeach
            </div>

            <div class="mt-8">
                {{ $posts->links() }}
            </div>
        @else
            <div class="text-center text-gray-500 py-12">
                Tidak ada tulisan yang ditemukan.
            </div>
        @endif
    </div>
@endsection