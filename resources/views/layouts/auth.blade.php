<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Paperlane')</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700|instrument-serif:400,400i&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-[#F5F0E6] text-[#3E2723]">
    <div class="min-h-screen grid lg:grid-cols-2">
        <!-- Kiri: Branding -->
        <div class="hidden lg:flex flex-col justify-between bg-[#3E2723] text-[#F5F0E6] p-12">
            <a href="{{ route('home') }}" class="font-serif text-3xl tracking-tight">
                Paperlane
            </a>

            <div>
                <h2 class="font-serif text-5xl leading-[1.1] mb-6">
                    Tulis. Terbitkan.<br>
                    <span class="italic">Bagikan.</span>
                </h2>
                <p class="text-[#F5F0E6]/70 leading-relaxed max-w-md">
                    Tempat sederhana untuk menulis dan membaca. Tanpa gangguan, tanpa iklan, hanya kata-kata.
                </p>
            </div>

            <div class="text-xs text-[#F5F0E6]/40">
                &copy; {{ date('Y') }} Paperlane
            </div>
        </div>

        <!-- Kanan: Form -->
        <div class="flex flex-col justify-center items-center p-6 lg:p-12">
            <div class="w-full max-w-md">
                <a href="{{ route('home') }}" class="lg:hidden font-serif text-2xl mb-8 inline-block">
                    Paperlane
                </a>

                @yield('content')
            </div>
        </div>
    </div>
</body>
</html>