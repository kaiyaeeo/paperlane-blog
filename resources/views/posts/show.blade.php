@extends('layouts.paperlane')

@section('title', $post->title . ' - Paperlane')

@section('content')
    <div class="max-w-3xl mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold mb-2">{{ $post->title }}</h1>
        
        <div class="flex items-center text-sm text-gray-500 mb-6 space-x-4">
            <span>Oleh: {{ $post->user->name }}</span>
            <span>Kategori: {{ $post->category ? $post->category->name : '-' }}</span>
            <span>Status: {{ $post->status }}</span>
        </div>

        <div class="prose max-w-none text-gray-800">
            {!! nl2br(e($post->content)) !!}
        </div>

        <div class="mt-8 flex gap-2">
            @foreach($post->tags as $tag)
                <span class="text-xs bg-gray-200 text-gray-700 px-2 py-1 rounded-full">{{ $tag->name }}</span>
            @endforeach
        </div>

        <div class="mt-8">
            <a href="{{ route('posts.index') }}" class="text-gray-600 hover:text-gray-900">&larr; Kembali ke Daftar Post</a>
        </div>
    </div>
@endsection