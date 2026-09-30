@extends('layouts.auth')

@section('title', 'Verifikasi Email — Paperlane')

@section('content')
    <div class="mb-8">
        <h1 class="font-serif text-3xl mb-2">Verifikasi email</h1>
        <p class="text-ink/70 text-sm leading-relaxed">
            Terima kasih sudah mendaftar! Sebelum mulai, tolong verifikasi alamat email kamu dengan mengklik tautan yang baru saja kami kirimkan.
            Kalau kamu tidak menerima emailnya, kami bisa mengirim ulang.
        </p>
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="mb-6 text-sm text-ink bg-accent/50 px-4 py-3 rounded-lg">
            Tautan verifikasi baru sudah dikirim ke alamat email yang kamu daftarkan.
        </div>
    @endif

    <div class="flex items-center justify-between gap-4">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <button type="submit" class="px-6 py-3 bg-ink text-paper rounded-full hover:bg-ink/85 transition text-sm font-medium">
                Kirim Ulang Email
            </button>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="text-sm text-ink/70 hover:text-ink underline-offset-2 hover:underline">
                Log out
            </button>
        </form>
    </div>
@endsection