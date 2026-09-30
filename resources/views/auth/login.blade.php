@extends('layouts.auth')

@section('title', 'Masuk — Paperlane')

@section('content')
    <div class="mb-8">
        <h1 class="font-serif text-3xl mb-2">Selamat datang kembali</h1>
        <p class="text-ink/60 text-sm">Masuk untuk melanjutkan menulis.</p>
    </div>

    @if (session('status'))
        <div class="mb-6 text-sm text-ink bg-accent/50 px-4 py-3 rounded-lg">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <div>
            <label for="email" class="block text-sm font-medium mb-2">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                class="w-full bg-surface border-ink/15 rounded-lg shadow-sm focus:border-ink focus:ring-[#3E2723] text-ink px-4 py-3">
            @error('email') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="password" class="block text-sm font-medium mb-2">Password</label>
            <input id="password" type="password" name="password" required autocomplete="current-password"
                class="w-full bg-surface border-ink/15 rounded-lg shadow-sm focus:border-ink focus:ring-[#3E2723] text-ink px-4 py-3">
            @error('password') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="flex items-center justify-between text-sm">
            <label class="flex items-center gap-2 cursor-pointer">
                <input type="checkbox" name="remember" class="rounded border-ink/30 text-ink focus:ring-[#3E2723]">
                <span class="text-ink/70">Ingat saya</span>
            </label>

            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="text-ink/70 hover:text-ink underline-offset-2 hover:underline">
                    Lupa password?
                </a>
            @endif
        </div>

        <button type="submit" class="w-full px-6 py-3 bg-ink text-paper rounded-full hover:bg-ink/85 transition text-sm font-medium">
            Masuk
        </button>

        <p class="text-center text-sm text-ink/70 pt-2">
            Belum punya akun?
            <a href="{{ route('register') }}" class="text-ink font-medium hover:underline">Daftar</a>
        </p>
    </form>
@endsection