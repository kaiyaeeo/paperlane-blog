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
<body class="font-sans antialiased bg-[#F7F9E1] text-[#204654]">
    <div class="min-h-screen flex flex-col">
        <!-- Navbar -->
        <nav class="sticky top-0 z-50 bg-[#F7F9E1]/90 backdrop-blur-md border-b border-[#204654]/10">
            <div class="w-full px-6 lg:px-12">
                <div class="flex justify-between items-center h-14">
                    <a href="{{ route('home') }}" class="font-serif text-xl text-[#204654] tracking-tight">
                        Paperlane
                    </a>
                    <div class="flex items-center gap-5">
                        <a href="{{ route('blog.index') }}" class="text-sm text-[#204654]/70 hover:text-[#204654] transition">
                            Blog
                        </a>
                        @auth
                            <a href="{{ url('/dashboard') }}" class="text-sm text-[#204654]/70 hover:text-[#204654] transition">
                                Dashboard
                            </a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="text-sm text-[#204654]/70 hover:text-[#204654] transition">
                                    Log out
                                </button>
                            </form>
                        @else
                            <a href="{{ route('login') }}" class="text-sm text-[#204654]/70 hover:text-[#204654] transition">
                                Log in
                            </a>
                            <a href="{{ route('register') }}" class="text-sm px-4 py-1.5 bg-[#204654] text-[#F7F9E1] rounded-full hover:bg-[#204654]/85 transition">
                                Mulai Menulis
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
        </nav>

        <!-- Konten Utama -->
        <main class="flex-1">
            @yield('content')
        </main>

        <!-- Footer -->
        <footer class="border-t border-[#204654]/10 mt-16">
            <div class="w-full px-6 lg:px-12 py-8">
                <div class="flex flex-col md:flex-row justify-between items-center gap-3">
                    <div class="font-serif text-lg text-[#204654]">Paperlane</div>
                    <div class="text-xs text-[#204654]/60">
                        &copy; {{ date('Y') }} Paperlane &middot; Ruang menulis digital.
                    </div>
                </div>
            </div>
        </footer>
    </div>
</body>
</html>