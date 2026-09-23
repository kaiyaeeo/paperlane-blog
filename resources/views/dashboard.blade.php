@extends('layouts.paperlane')

@section('title', 'Dashboard - Paperlane')

@section('content')
    <div class="max-w-3xl mx-auto px-4 py-16 text-center">
        <h1 class="text-3xl font-bold mb-4">Dashboard</h1>
        <p class="text-gray-600 mb-8">
            Selamat datang, <strong>{{ auth()->user()->name }}</strong>!
        </p>
        <a href="{{ route('posts.index') }}" class="px-6 py-3 bg-gray-900 text-white rounded-lg hover:bg-gray-700 transition">
            Kelola Post Saya
        </a>
    </div>
@endsection