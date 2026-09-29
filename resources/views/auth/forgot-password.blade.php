@extends('layouts.auth')

@section('title', 'Lupa Password — Paperlane')

@section('content')
    <div class="mb-8">
        <h1 class="font-serif text-3xl mb-2">Lupa password?</h1>
        <p class="text-[#3E2723]/60 text-sm">
            Masukkan email kamu, kami akan kirimkan tautan untuk mengatur ulang password.
        </p>
    </div>

    @if (session('status'))
        <div class="mb-6 text-sm text-[#3E2723] bg-[#F4C9D6]/50 px-4 py-3 rounded-lg">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
        @csrf

        <div>
            <label for="email" class="block text-sm font-medium mb-2">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                class="w-full bg-white border-[#3E2723]/15 rounded-lg shadow-sm focus:border-[#3E2723] focus:ring-[#3E2723] text-[#3E2723] px-4 py-3">
            @error('email') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <button type="submit" class="w-full px-6 py-3 bg-[#3E2723] text-[#F5F0E6] rounded-full hover:bg-[#3E2723]/85 transition text-sm font-medium">
            Kirim Tautan Reset
        </button>

        <p class="text-center text-sm text-[#3E2723]/70 pt-2">
            Ingat password-mu?
            <a href="{{ route('login') }}" class="text-[#3E2723] font-medium hover:underline">Kembali ke login</a>
        </p>
    </form>
@endsection