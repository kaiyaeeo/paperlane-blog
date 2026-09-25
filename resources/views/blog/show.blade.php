@extends('layouts.paperlane')

@section('title', $post->title . ' - Paperlane')

@section('content')
    <div class="max-w-3xl mx-auto px-4 py-8">
        <!-- Header Post -->
        <div class="mb-8">
            @if($post->category)
                <a href="{{ route('blog.category', $post->category) }}" class="text-sm text-gray-500 uppercase tracking-wide hover:text-gray-900">
                    {{ $post->category->name }}
                </a>
            @endif
            <h1 class="text-3xl font-bold mt-2 mb-4">{{ $post->title }}</h1>
            <div class="text-sm text-gray-500">
                Oleh <strong>{{ $post->user->name }}</strong> &middot; 
                {{ $post->created_at->format('d M Y') }}
            </div>
        </div>

        <!-- Konten -->
        <div class="prose max-w-none text-gray-800 leading-relaxed mb-8">
            {!! nl2br(e($post->content)) !!}
        </div>

        <!-- Tag -->
        @if($post->tags->count() > 0)
            <div class="flex gap-2 mb-8">
                @foreach($post->tags as $tag)
                    <a href="{{ route('blog.tag', $tag) }}" class="text-xs bg-gray-200 text-gray-700 px-3 py-1 rounded-full hover:bg-gray-300">
                        #{{ $tag->name }}
                    </a>
                @endforeach
            </div>
        @endif

        <hr class="my-8">

        <!-- Post Terkait -->
        @if($relatedPosts->count() > 0)
            <div>
                <h2 class="text-lg font-semibold mb-4">Tulisan Terkait</h2>
                <div class="space-y-3">
                    @foreach($relatedPosts as $related)
                        <div>
                            <a href="{{ route('blog.show', $related) }}" class="text-blue-600 hover:text-blue-800">
                                {{ $related->title }}
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <div class="mt-12">
            <a href="{{ route('blog.index') }}" class="text-gray-600 hover:text-gray-900">&larr; Kembali ke Blog</a>
        </div>
    </div>
@endsection