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
<body class="font-sans antialiased bg-stone-50 text-stone-900">
    <div class="min-h-screen flex flex-col">
        <!-- Navbar -->
        <nav class="sticky top-0 z-50 bg-stone-50/80 backdrop-blur-md border-b border-stone-200/60">
            <div class="max-w-5xl mx-auto px-6 lg:px-8">
                <div class="flex justify-between items-center h-16">
                    <a href="{{ route('home') }}" class="font-serif text-2xl text-stone-900 tracking-tight">
                        Paperlane
                    </a>
                    <div class="flex items-center gap-6">
                        <a href="{{ route('blog.index') }}" class="text-sm text-stone-600 hover:text-stone-900 transition">
                            Blog
                        </a>
                        @auth
                            <a href="{{ url('/dashboard') }}" class="text-sm text-stone-600 hover:text-stone-900 transition">
                                Dashboard
                            </a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="text-sm text-stone-600 hover:text-stone-900 transition">
                                    Log out
                                </button>
                            </form>
                        @else
                            <a href="{{ route('login') }}" class="text-sm text-stone-600 hover:text-stone-900 transition">
                                Log in
                            </a>
                            <a href="{{ route('register') }}" class="text-sm px-4 py-2 bg-stone-900 text-white rounded-full hover:bg-stone-700 transition">
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
        <footer class="border-t border-stone-200 mt-24">
            <div class="max-w-5xl mx-auto px-6 lg:px-8 py-12">
                <div class="flex flex-col md:flex-row justify-between items-center gap-4">
                    <div class="font-serif text-xl text-stone-900">Paperlane</div>
                    <div class="text-sm text-stone-500">
                        &copy; {{ date('Y') }} Paperlane &middot; Ruang menulis digital.
                    </div>
                </div>
            </div>
        </footer>
    </div>
</body>
</html>