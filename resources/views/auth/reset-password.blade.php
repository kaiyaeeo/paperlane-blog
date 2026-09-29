@extends('layouts.auth')

@section('title', 'Reset Password — Paperlane')

@section('content')
    <div class="mb-8">
        <h1 class="font-serif text-3xl mb-2">Reset password</h1>
        <p class="text-[#3E2723]/60 text-sm">Buat password baru untuk akunmu.</p>
    </div>

    <form method="POST" action="{{ route('password.store') }}" class="space-y-5">
        @csrf
        @method('POST')

        <!-- Token -->
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <div>
            <label for="email" class="block text-sm font-medium mb-2">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email', $request->email) }}" required autofocus
                class="w-full bg-white border-[#3E2723]/15 rounded-lg shadow-sm focus:border-[#3E2723] focus:ring-[#3E2723] text-[#3E2723] px-4 py-3">
            @error('email') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="password" class="block text-sm font-medium mb-2">Password Baru</label>
            <input id="password" type="password" name="password" required autocomplete="new-password"
                class="w-full bg-white border-[#3E2723]/15 rounded-lg shadow-sm focus:border-[#3E2723] focus:ring-[#3E2723] text-[#3E2723] px-4 py-3">
            @error('password') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="password_confirmation" class="block text-sm font-medium mb-2">Konfirmasi Password</label>
            <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                class="w-full bg-white border-[#3E2723]/15 rounded-lg shadow-sm focus:border-[#3E2723] focus:ring-[#3E2723] text-[#3E2723] px-4 py-3">
            @error('password_confirmation') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <button type="submit" class="w-full px-6 py-3 bg-[#3E2723] text-[#F5F0E6] rounded-full hover:bg-[#3E2723]/85 transition text-sm font-medium">
            Reset Password
        </button>
    </form>
@endsection