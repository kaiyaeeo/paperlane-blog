@extends('layouts.auth')

@section('title', 'Daftar — Paperlane')

@section('content')
    <div class="mb-8">
        <h1 class="font-serif text-3xl mb-2">Mulai menulis</h1>
        <p class="text-[#3E2723]/60 text-sm">Buat akun Paperlane-mu dalam sekejap.</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-5">
        @csrf

        <div>
            <label for="name" class="block text-sm font-medium mb-2">Nama</label>
            <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus
                class="w-full bg-white border-[#3E2723]/15 rounded-lg shadow-sm focus:border-[#3E2723] focus:ring-[#3E2723] text-[#3E2723] px-4 py-3">
            @error('name') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="email" class="block text-sm font-medium mb-2">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required
                class="w-full bg-white border-[#3E2723]/15 rounded-lg shadow-sm focus:border-[#3E2723] focus:ring-[#3E2723] text-[#3E2723] px-4 py-3">
            @error('email') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="password" class="block text-sm font-medium mb-2">Password</label>
            <input id="password" type="password" name="password" required autocomplete="new-password"
                class="w-full bg-white border-[#3E2723]/15 rounded-lg shadow-sm focus:border-[#3E2723] focus:ring-[#3E2723] text-[#3E2723] px-4 py-3">
            @error('password') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="password_confirmation" class="block text-sm font-medium mb-2">Konfirmasi Password</label>
            <input id="password_confirmation" type="password" name="password_confirmation" required
                class="w-full bg-white border-[#3E2723]/15 rounded-lg shadow-sm focus:border-[#3E2723] focus:ring-[#3E2723] text-[#3E2723] px-4 py-3">
        </div>

        <button type="submit" class="w-full px-6 py-3 bg-[#3E2723] text-[#F5F0E6] rounded-full hover:bg-[#3E2723]/85 transition text-sm font-medium">
            Daftar
        </button>

        <p class="text-center text-sm text-[#3E2723]/70 pt-2">
            Sudah punya akun?
            <a href="{{ route('login') }}" class="text-[#3E2723] font-medium hover:underline">Masuk</a>
        </p>
    </form>
@endsection