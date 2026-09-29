@extends('layouts.auth')

@section('title', 'Konfirmasi Password — Paperlane')

@section('content')
    <div class="mb-8">
        <h1 class="font-serif text-3xl mb-2">Konfirmasi password</h1>
        <p class="text-[#3E2723]/60 text-sm">
            Ini adalah area aman. Masukkan password kamu untuk melanjutkan.
        </p>
    </div>

    <form method="POST" action="{{ route('password.confirm') }}" class="space-y-5">
        @csrf

        <div>
            <label for="password" class="block text-sm font-medium mb-2">Password</label>
            <input id="password" type="password" name="password" required autofocus autocomplete="current-password"
                class="w-full bg-white border-[#3E2723]/15 rounded-lg shadow-sm focus:border-[#3E2723] focus:ring-[#3E2723] text-[#3E2723] px-4 py-3">
            @error('password') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="flex items-center justify-between">
            <button type="submit" class="px-6 py-3 bg-[#3E2723] text-[#F5F0E6] rounded-full hover:bg-[#3E2723]/85 transition text-sm font-medium">
                Konfirmasi
            </button>

            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="text-sm text-[#3E2723]/70 hover:text-[#3E2723] underline-offset-2 hover:underline">
                    Lupa password?
                </a>
            @endif
        </div>
    </form>
@endsection