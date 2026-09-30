@extends('layouts.auth')

@section('title', 'Lupa Password — Paperlane')

@section('content')
    <div class="mb-8">
        <h1 class="font-serif text-3xl mb-2">Lupa password?</h1>
        <p class="text-ink/60 text-sm">
            Masukkan email kamu, kami akan kirimkan tautan untuk mengatur ulang password.
        </p>
    </div>

    @if (session('status'))
        <div class="mb-6 text-sm text-ink bg-accent/50 px-4 py-3 rounded-lg">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
        @csrf

        <div>
            <label for="email" class="block text-sm font-medium mb-2">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                class="w-full bg-surface border-ink/15 rounded-lg shadow-sm focus:border-ink focus:ring-[#3E2723] text-ink px-4 py-3">
            @error('email') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <button type="submit" class="w-full px-6 py-3 bg-ink text-paper rounded-full hover:bg-ink/85 transition text-sm font-medium">
            Kirim Tautan Reset
        </button>

        <p class="text-center text-sm text-ink/70 pt-2">
            Ingat password-mu?
            <a href="{{ route('login') }}" class="text-ink font-medium hover:underline">Kembali ke login</a>
        </p>
    </form>
@endsection