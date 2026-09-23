@extends('layouts.paperlane')

@section('title', 'Post Saya - Paperlane')

@section('content')
    <div class="max-w-4xl mx-auto px-4 py-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">Post Saya</h1>
            <a href="{{ route('posts.create') }}" class="px-4 py-2 bg-gray-900 text-white rounded-lg hover:bg-gray-700 transition">
                + Buat Post
            </a>
        </div>

        @if(session('success'))
            <div class="bg-green-100 text-green-800 p-4 rounded-lg mb-4">
                {{ session('success') }}
            </div>
        @endif

        <div class="space-y-4">
            @forelse($posts as $post)
                <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-100">
                    <h2 class="text-lg font-semibold">{{ $post->title }}</h2>
                    <p class="text-sm text-gray-500">Status: {{ $post->status }}</p>
                </div>
            @empty
                <p class="text-gray-500">Belum ada post. Ayo buat post pertama kamu!</p>
            @endforelse
        </div>

        <div class="mt-6">
            {{ $posts->links() }}
        </div>
    </div>
@endsection