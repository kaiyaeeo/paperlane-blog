@extends('layouts.paperlane')

@section('title', $post->title . ' — Paperlane')

@section('content')
    <article class="max-w-2xl mx-auto px-6 lg:px-8 py-16">
        <!-- Back -->
        <a href="{{ route('blog.index') }}" class="text-sm text-stone-500 hover:text-stone-900 transition inline-block mb-10">
            &larr; Kembali
        </a>

        <!-- Header -->
        @if($post->category)
            <a href="{{ route('blog.category', $post->category) }}" class="text-xs text-stone-500 uppercase tracking-widest hover:text-stone-900 transition">
                {{ $post->category->name }}
            </a>
        @endif
        <h1 class="font-serif text-4xl md:text-5xl text-stone-900 leading-[1.1] mt-4 mb-6">
            {{ $post->title }}
        </h1>
        <div class="flex items-center gap-3 text-sm text-stone-500 mb-12">
            <span>Oleh <strong class="text-stone-700">{{ $post->user->name }}</strong></span>
            <span>&middot;</span>
            <span>{{ $post->created_at->format('d M Y') }}</span>
        </div>

        <!-- Konten -->
        <div class="text-stone-800 leading-[1.8] text-lg space-y-6">
            {!! nl2br(e($post->content)) !!}
        </div>

        <!-- Tag -->
        @if($post->tags->count() > 0)
            <div class="flex flex-wrap gap-2 mt-12 pt-8 border-t border-stone-200">
                @foreach($post->tags as $tag)
                    <a href="{{ route('blog.tag', $tag) }}" class="text-xs px-3 py-1 rounded-full border border-stone-300 text-stone-600 hover:border-stone-900 hover:text-stone-900 transition">
                        #{{ $tag->name }}
                    </a>
                @endforeach
            </div>
        @endif
    </article>

    <!-- Post Terkait -->
    @if($relatedPosts->count() > 0)
        <section class="max-w-2xl mx-auto px-6 lg:px-8 py-16 border-t border-stone-200">
            <h2 class="font-serif text-2xl text-stone-900 mb-8">Tulisan Terkait</h2>
            <div class="space-y-6">
                @foreach($relatedPosts as $related)
                    <a href="{{ route('blog.show', $related) }}" class="block group">
                        <h3 class="font-serif text-xl text-stone-900 group-hover:text-stone-600 transition mb-1">
                            {{ $related->title }}
                        </h3>
                        <p class="text-sm text-stone-500">
                            {{ $related->created_at->format('d M Y') }}
                        </p>
                    </a>
                @endforeach
            </div>
        </section>
    @endif
@endsection