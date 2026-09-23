@extends('layouts.paperlane')

@section('title', 'Beranda - Paperlane')

@section('content')
    <div class="max-w-3xl mx-auto px-4 py-16">
        <div class="text-center">
            <h1 class="text-4xl font-bold text-gray-900 mb-4">
                Selamat Datang di Paperlane
            </h1>
            <p class="text-lg text-gray-600 mb-8">
                Ruang menulis digital. Tempat kamu menulis, menerbitkan, dan membaca tulisan dengan antarmuka yang bersih.
            </p>

            @guest
                <div class="space-x-4">
                    <a href="{{ route('register') }}" class="inline-block px-6 py-3 bg-gray-900 text-white rounded-lg hover:bg-gray-700 transition">
                        Mulai Menulis
                    </a>
                    <a href="{{ route('login') }}" class="inline-block px-6 py-3 border border-gray-300 rounded-lg hover:bg-gray-100 transition">
                        Masuk
                    </a>
                </div>
            @endguest

            @auth
                <a href="{{ url('/dashboard') }}" class="inline-block px-6 py-3 bg-gray-900 text-white rounded-lg hover:bg-gray-700 transition">
                    Ke Dashboard
                </a>
            @endauth
        </div>
    </div>
@endsection