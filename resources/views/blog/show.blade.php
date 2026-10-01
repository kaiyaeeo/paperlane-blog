@extends('layouts.paperlane')

@section('title', $post->title . ' — Paperlane')

@section('meta')
    @include('partials.seo', [
        'title' => $post->title . ' — Paperlane',
        'description' => \Illuminate\Support\Str::limit(strip_tags($post->content), 160),
        'image' => $post->user->avatar_url,
        'type' => 'article',
    ])
@endsection

@section('content')
    {{-- Reading Progress Bar --}}
    <div id="reading-progress" class="fixed top-0 left-0 h-[3px] bg-accent z-[60] transition-all duration-75" style="width: 0%"></div>

    <div class="w-full px-6 lg:px-12 py-12">
        <article class="max-w-3xl">
            {{-- Back --}}
            <a href="{{ route('blog.index') }}" class="text-sm text-ink/60 hover:text-ink transition inline-block mb-8">
                &larr; Kembali
            </a>

            {{-- Header --}}
            @if($post->category)
                <a href="{{ route('blog.category', $post->category) }}" class="text-xs text-ink/60 uppercase tracking-widest hover:text-ink transition">
                    {{ $post->category->name }}
                </a>
            @endif
            <h1 class="font-serif text-3xl md:text-5xl text-ink leading-[1.1] mt-3 mb-4">
                {{ $post->title }}
            </h1>
            <div class="flex items-center gap-2 text-xs text-ink/60 mb-6">
                <span>Oleh
                    <a href="{{ route('profile.show', $post->user) }}" class="font-medium text-ink hover:underline">
                        {{ $post->user->name }}
                    </a>
                </span>
                <span>&middot;</span>
                <span>{{ $post->created_at->format('d M Y') }}</span>
                <span>&middot;</span>
                <span>{{ ceil(str_word_count(strip_tags($post->content)) / 200) }} menit baca</span>
            </div>

            {{-- Action Bar --}}
            <div class="flex items-center gap-4 mb-10 pb-6 border-b border-ink/10">
                @auth
                    @php
                        $isLiked = $post->likes->where('user_id', auth()->id())->count() > 0;
                        $isBookmarked = $post->bookmarks->where('user_id', auth()->id())->count() > 0;
                    @endphp

                    <form action="{{ route('likes.toggle', $post) }}" method="POST">
                        @csrf
                        <button type="submit" class="flex items-center gap-2 text-sm transition {{ $isLiked ? 'text-red-500' : 'text-ink/60 hover:text-ink' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="{{ $isLiked ? 'currentColor' : 'none' }}" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                            </svg>
                            <span>{{ $post->likes->count() }}</span>
                        </button>
                    </form>

                    <form action="{{ route('bookmarks.toggle', $post) }}" method="POST">
                        @csrf
                        <button type="submit" class="flex items-center gap-2 text-sm transition {{ $isBookmarked ? 'text-ink' : 'text-ink/60 hover:text-ink' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="{{ $isBookmarked ? 'currentColor' : 'none' }}" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z" />
                            </svg>
                            <span>{{ $isBookmarked ? 'Disimpan' : 'Simpan' }}</span>
                        </button>
                    </form>
                @else
                    <div class="flex items-center gap-4 text-sm text-ink/60">
                        <div class="flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                            </svg>
                            <span>{{ $post->likes->count() }}</span>
                        </div>
                        <a href="{{ route('login') }}" class="underline hover:no-underline text-ink">Login</a>
                        <span>untuk like & simpan</span>
                    </div>
                @endauth
            </div>

            {{-- Konten --}}
            <div class="prose-paperlane text-ink leading-[1.8] text-base md:text-lg">
                {!! $post->content !!}
            </div>

            {{-- Tag --}}
            @if($post->tags->count() > 0)
                <div class="flex flex-wrap gap-2 mt-10 pt-6 border-t border-ink/10">
                    @foreach($post->tags as $tag)
                        <a href="{{ route('blog.tag', $tag) }}" class="text-xs px-3 py-1 rounded-full bg-accent/60 text-ink hover:bg-accent transition">
                            #{{ $tag->name }}
                        </a>
                    @endforeach
                </div>
            @endif

            {{-- Share Buttons --}}
            <div class="flex flex-wrap items-center gap-2 mt-8 pt-8 border-t border-ink/10">
                <span class="text-xs text-ink/50 uppercase tracking-widest mr-2">Bagikan</span>

                <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->url()) }}&text={{ urlencode($post->title) }}" 
                    target="_blank" rel="noopener noreferrer"
                    class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs bg-surface border border-ink/10 rounded-full text-ink/70 hover:text-ink hover:border-ink/30 transition">
                    <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                    X
                </a>

                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}" 
                    target="_blank" rel="noopener noreferrer"
                    class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs bg-surface border border-ink/10 rounded-full text-ink/70 hover:text-ink hover:border-ink/30 transition">
                    <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                    Facebook
                </a>

                <a href="https://wa.me/?text={{ urlencode($post->title . ' — ' . request()->url()) }}" 
                    target="_blank" rel="noopener noreferrer"
                    class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs bg-surface border border-ink/10 rounded-full text-ink/70 hover:text-ink hover:border-ink/30 transition">
                    <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                    WhatsApp
                </a>

                <a href="https://t.me/share/url?url={{ urlencode(request()->url()) }}&text={{ urlencode($post->title) }}" 
                    target="_blank" rel="noopener noreferrer"
                    class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs bg-surface border border-ink/10 rounded-full text-ink/70 hover:text-ink hover:border-ink/30 transition">
                    <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M11.944 0A12 12 0 0 0 0 12a12 12 0 0 0 12 12 12 12 0 0 0 12-12A12 12 0 0 0 12 0a12 12 0 0 0-.056 0zm4.962 7.224c.1-.002.321.023.465.14a.506.506 0 0 1 .171.325c.016.093.036.306.02.472-.18 1.898-.962 6.502-1.36 8.627-.168.9-.499 1.201-.82 1.23-.696.065-1.225-.46-1.9-.902-1.056-.693-1.653-1.124-2.678-1.8-1.185-.78-.417-1.21.258-1.91.177-.184 3.247-2.977 3.307-3.23.007-.032.014-.15-.056-.212s-.174-.041-.249-.024c-.106.024-1.793 1.14-5.061 3.345-.48.33-.913.49-1.302.48-.428-.008-1.252-.241-1.865-.44-.752-.245-1.349-.374-1.297-.789.027-.216.325-.437.893-.663 3.498-1.524 5.83-2.529 6.998-3.014 3.332-1.386 4.025-1.627 4.476-1.635z"/></svg>
                    Telegram
                </a>

                <button type="button" onclick="copyShareLink(this)" 
                    class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs bg-surface border border-ink/10 rounded-full text-ink/70 hover:text-ink hover:border-ink/30 transition">
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />
                    </svg>
                    <span class="copy-label">Salin Tautan</span>
                </button>
            </div>

            {{-- Komentar --}}
            <section class="mt-12 pt-10 border-t border-ink/10">
                <h2 class="font-serif text-xl md:text-2xl text-ink mb-6">
                    Komentar ({{ $post->comments->count() }})
                </h2>

                @if(session('success'))
                    <div class="bg-accent/50 text-ink px-4 py-3 rounded-lg mb-6 text-sm">
                        {{ session('success') }}
                    </div>
                @endif

                @auth
                    <form action="{{ route('comments.store', $post) }}" method="POST" class="mb-10">
                        @csrf
                        <div class="mb-3">
                            <textarea name="content" rows="3" 
                                placeholder="Tulis komentar..." 
                                class="w-full bg-surface border-ink/20 rounded-lg shadow-sm focus:border-ink focus:ring-ink text-sm text-ink px-4 py-3">{{ old('content') }}</textarea>
                            @error('content') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                        <button type="submit" class="px-5 py-2 bg-ink text-paper rounded-full hover:bg-ink/85 transition text-sm">
                            Kirim Komentar
                        </button>
                    </form>
                @else
                    <div class="mb-10 p-4 border border-ink/15 rounded-lg text-sm text-ink/75 bg-accent/30">
                        <a href="{{ route('login') }}" class="text-ink underline hover:no-underline">Login</a> untuk menulis komentar.
                    </div>
                @endauth

                <div class="space-y-5">
                    @forelse($post->comments as $comment)
                        <div class="flex gap-3">
                            <div class="flex-shrink-0">
                                <a href="{{ route('profile.show', $comment->user) }}">
                                    <img src="{{ $comment->user->avatar_url }}" alt="{{ $comment->user->name }}" class="w-9 h-9 rounded-full object-cover">
                                </a>
                            </div>
                            <div class="flex-1">
                                <div class="flex items-baseline gap-2 mb-1">
                                    <a href="{{ route('profile.show', $comment->user) }}" class="font-medium text-ink text-sm hover:underline">
                                        {{ $comment->user->name }}
                                    </a>
                                    <span class="text-xs text-ink/50">{{ $comment->created_at->diffForHumans() }}</span>
                                </div>
                                <p class="text-ink/85 leading-relaxed text-sm">
                                    {{ $comment->content }}
                                </p>

                                @auth
                                    @if($comment->user_id === auth()->id() || $post->user_id === auth()->id() || auth()->user()->isAdmin())
                                        <form action="{{ route('comments.destroy', $comment) }}" method="POST" class="mt-2" onsubmit="return confirm('Hapus komentar ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-xs text-ink/50 hover:text-red-600 transition">
                                                Hapus
                                            </button>
                                        </form>
                                    @endif
                                @endauth
                            </div>
                        </div>
                    @empty
                        <p class="text-ink/50 text-sm italic">Belum ada komentar. Jadilah yang pertama!</p>
                    @endforelse
                </div>
            </section>
        </article>

        @if($relatedPosts->count() > 0)
            <section class="max-w-3xl mt-12 pt-10 border-t border-ink/10">
                <div class="flex items-baseline justify-between mb-6">
                    <h2 class="font-serif text-xl text-ink">Tulisan Terkait</h2>
                    <span class="text-xs text-ink/40 uppercase tracking-widest">Pilihan untukmu</span>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @foreach($relatedPosts as $related)
                        @php
                            // Hitung tag yang sama untuk indikator
                            $currentTagIds = $post->tags->pluck('id')->all();
                            $sharedTags = $related->tags->whereIn('id', $currentTagIds);
                        @endphp
                        <a href="{{ route('blog.show', $related) }}" class="block group">
                            @if($related->category)
                                <span class="text-xs text-ink/50 uppercase tracking-widest">
                                    {{ $related->category->name }}
                                </span>
                            @endif
                            <h3 class="font-serif text-lg text-ink group-hover:text-ink/70 transition mt-1 mb-2 leading-snug">
                                {{ $related->title }}
                            </h3>

                            {{-- Indikator kenapa post ini terkait --}}
                            @if($sharedTags->count() > 0)
                                <div class="flex flex-wrap gap-1 mb-2">
                                    @foreach($sharedTags->take(2) as $t)
                                        <span class="text-[10px] px-2 py-0.5 rounded-full bg-accent/60 text-ink">
                                            #{{ $t->name }}
                                        </span>
                                    @endforeach
                                </div>
                            @else
                                <p class="text-xs text-ink/50 mb-2">
                                    Kategori sama
                                </p>
                            @endif

                            <div class="flex items-center gap-3 text-xs text-ink/40">
                                <span>{{ $related->created_at->format('d M Y') }}</span>
                                <span>&middot;</span>
                                <span class="flex items-center gap-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                    </svg>
                                    {{ $related->likes->count() }}
                                </span>
                            </div>
                        </a>
                    @endforeach
                </div>
            </section>
        @endif
    </div>

    <script>
        // Reading Progress Bar
        (function () {
            const bar = document.getElementById('reading-progress');
            if (!bar) return;

            function update() {
                const scrollTop = window.scrollY || document.documentElement.scrollTop;
                const docHeight = document.documentElement.scrollHeight - window.innerHeight;
                const percent = docHeight > 0 ? (scrollTop / docHeight) * 100 : 0;
                bar.style.width = Math.min(Math.max(percent, 0), 100) + '%';
            }

            window.addEventListener('scroll', update, { passive: true });
            window.addEventListener('resize', update);
            update();
        })();

        // Copy Share Link
        function copyShareLink(btn) {
            const url = window.location.href;
            const label = btn.querySelector('.copy-label');
            const original = label.textContent;

            const done = () => {
                label.textContent = 'Tersalin!';
                setTimeout(() => { label.textContent = original; }, 2000);
            };

            if (navigator.clipboard && window.isSecureContext) {
                navigator.clipboard.writeText(url).then(done).catch(() => fallback());
            } else {
                fallback();
            }

            function fallback() {
                const ta = document.createElement('textarea');
                ta.value = url;
                ta.style.position = 'absolute';
                ta.style.left = '-9999px';
                document.body.appendChild(ta);
                ta.select();
                try { document.execCommand('copy'); done(); } catch (e) { console.error('Gagal copy', e); }
                document.body.removeChild(ta);
            }
        }
    </script>
@endsection