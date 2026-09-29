@extends('layouts.auth')

@section('title', 'Masuk — Paperlane')

@section('content')
    <div class="mb-8">
        <h1 class="font-serif text-3xl mb-2">Selamat datang kembali</h1>
        <p class="text-[#3E2723]/60 text-sm">Masuk untuk melanjutkan menulis.</p>
    </div>

    @if (session('status'))
        <div class="mb-6 text-sm text-[#3E2723] bg-[#F4C9D6]/50 px-4 py-3 rounded-lg">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <div>
            <label for="email" class="block text-sm font-medium mb-2">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                class="w-full bg-white border-[#3E2723]/15 rounded-lg shadow-sm focus:border-[#3E2723] focus:ring-[#3E2723] text-[#3E2723] px-4 py-3">
            @error('email') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="password" class="block text-sm font-medium mb-2">Password</label>
            <input id="password" type="password" name="password" required autocomplete="current-password"
                class="w-full bg-white border-[#3E2723]/15 rounded-lg shadow-sm focus:border-[#3E2723] focus:ring-[#3E2723] text-[#3E2723] px-4 py-3">
            @error('password') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="flex items-center justify-between text-sm">
            <label class="flex items-center gap-2 cursor-pointer">
                <input type="checkbox" name="remember" class="rounded border-[#3E2723]/30 text-[#3E2723] focus:ring-[#3E2723]">
                <span class="text-[#3E2723]/70">Ingat saya</span>
            </label>

            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="text-[#3E2723]/70 hover:text-[#3E2723] underline-offset-2 hover:underline">
                    Lupa password?
                </a>
            @endif
        </div>

        <button type="submit" class="w-full px-6 py-3 bg-[#3E2723] text-[#F5F0E6] rounded-full hover:bg-[#3E2723]/85 transition text-sm font-medium">
            Masuk
        </button>

        <p class="text-center text-sm text-[#3E2723]/70 pt-2">
            Belum punya akun?
            <a href="{{ route('register') }}" class="text-[#3E2723] font-medium hover:underline">Daftar</a>
        </p>
    </form>
@endsection