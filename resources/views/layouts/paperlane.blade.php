<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Paperlane')</title>

    @hasSection('meta')
        @yield('meta')
    @else
        <meta name="description" content="Ruang menulis digital Paperlane.">
    @endif

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700|instrument-serif:400,400i&display=swap" rel="stylesheet" />

    <!-- Dark mode init (harus inline, sebelum body render) -->
    <script>
        (function () {
            const stored = localStorage.getItem('theme');
            if (stored === 'dark' || (!stored && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                document.documentElement.classList.add('dark');
            }
        })();
    </script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-paper text-ink transition-colors">
    <div class="min-h-screen flex flex-col">
        <!-- Navbar -->
        <nav class="sticky top-0 z-50 bg-paper/90 backdrop-blur-md border-b border-ink/10">
            <div class="w-full px-6 lg:px-12">
                <div class="flex justify-between items-center h-14">
                    <a href="{{ route('home') }}" class="font-serif text-xl text-ink tracking-tight">
                        Paperlane
                    </a>
                    <div class="flex items-center gap-5">
                        <a href="{{ route('blog.index') }}" class="text-sm text-ink/70 hover:text-ink transition">Blog</a>
                        @auth
                            <a href="{{ route('profile.show', auth()->user()) }}" class="text-sm text-ink/70 hover:text-ink transition">Profil</a>
                            <a href="{{ url('/dashboard') }}" class="text-sm text-ink/70 hover:text-ink transition">Dashboard</a>
                            <a href="{{ route('bookmarks.index') }}" class="text-sm text-ink/70 hover:text-ink transition">Bookmark</a>
                            @if(auth()->user()->isAdmin())
                                <a href="{{ route('admin.users.index') }}" class="text-sm text-ink/70 hover:text-ink transition">Admin</a>
                            @endif
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="text-sm text-ink/70 hover:text-ink transition">Log out</button>
                            </form>
                        @else
                            <a href="{{ route('login') }}" class="text-sm text-ink/70 hover:text-ink transition">Log in</a>
                            <a href="{{ route('register') }}" class="text-sm px-4 py-1.5 bg-ink text-paper rounded-full hover:bg-ink/85 transition">
                                Mulai Menulis
                            </a>
                        @endauth

                        <!-- Dark mode toggle -->
                        <button onclick="toggleDarkMode()" 
                            class="w-9 h-9 flex items-center justify-center rounded-full text-ink/70 hover:text-ink hover:bg-ink/5 transition" 
                            aria-label="Toggle dark mode">
                            <!-- Sun icon (muncul di dark mode) -->
                            <svg class="w-5 h-5 hidden dark:block" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707m12.728 0l-.707-.707M6.343 6.343l-.707-.707M12 6a6 6 0 100 12 6 6 0 000-12z" />
                            </svg>
                            <!-- Moon icon (muncul di light mode) -->
                            <svg class="w-5 h-5 block dark:hidden" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </nav>

        <main class="flex-1">
            @yield('content')
        </main>

        <footer class="border-t border-ink/10 mt-16">
            <div class="w-full px-6 lg:px-12 py-8">
                <div class="flex flex-col md:flex-row justify-between items-center gap-3">
                    <div class="font-serif text-lg text-ink">Paperlane</div>
                    <div class="text-xs text-ink/60">
                        &copy; {{ date('Y') }} Paperlane &middot; Ruang menulis digital.
                    </div>
                </div>
            </div>
        </footer>
    </div>
</body>
</html>