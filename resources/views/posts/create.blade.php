@extends('layouts.paperlane')

@section('title', 'Buat Post Baru - Paperlane')

@section('content')
    <div class="w-full px-6 lg:px-12 py-12">
        <div class="mb-8">
            <a href="{{ route('posts.index') }}" class="text-sm text-ink/60 hover:text-ink transition">
                &larr; Kembali
            </a>
            <h1 class="font-serif text-3xl md:text-4xl text-ink mt-3">Buat Post Baru</h1>
            <p class="text-ink/70 mt-1">Tulis sesuatu yang berharga hari ini.</p>
        </div>

        <form action="{{ route('posts.store') }}" method="POST" class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            @csrf

            <div class="lg:col-span-2 space-y-6">
                <div class="bg-surface rounded-2xl border border-ink/10 p-6 space-y-5">
                    <div>
                        <label class="block text-sm font-medium mb-2 text-ink">Judul</label>
                        <input type="text" name="title" value="{{ old('title') }}" 
                            placeholder="Judul yang menarik..."
                            class="w-full bg-paper/50 border-ink/15 rounded-lg shadow-sm focus:border-ink focus:ring-ink text-ink text-lg font-serif px-4 py-3">
                        @error('title') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-2 text-ink">Konten</label>
                        <textarea name="content" id="content" rows="15">{{ old('content') }}</textarea>
                        @error('content') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>

            <div class="space-y-6">
                <div class="bg-surface rounded-2xl border border-ink/10 p-6">
                    <h3 class="font-serif text-lg text-ink mb-4">Publikasi</h3>
                    
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium mb-2 text-ink">Status</label>
                            <select name="status" class="w-full bg-paper/50 border-ink/15 rounded-lg shadow-sm focus:border-ink focus:ring-ink text-ink px-4 py-3">
                                <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                                <option value="published" {{ old('status') == 'published' ? 'selected' : '' }}>Published</option>
                            </select>
                        </div>

                        <button type="submit" class="w-full px-6 py-3 bg-ink text-paper rounded-full hover:bg-ink/85 transition text-sm font-medium">
                            Simpan Post
                        </button>
                        <a href="{{ route('posts.index') }}" class="block text-center text-sm text-ink/60 hover:text-ink transition">
                            Batal
                        </a>
                    </div>
                </div>

                <div class="bg-surface rounded-2xl border border-ink/10 p-6">
                    <h3 class="font-serif text-lg text-ink mb-4">Kategori</h3>
                    <select name="category_id" class="w-full bg-paper/50 border-ink/15 rounded-lg shadow-sm focus:border-ink focus:ring-ink text-ink px-4 py-3">
                        <option value="">-- Pilih Kategori --</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div class="bg-surface rounded-2xl border border-ink/10 p-6">
                    <h3 class="font-serif text-lg text-ink mb-4">Tag</h3>
                    <div class="space-y-2 max-h-48 overflow-y-auto">
                        @foreach($tags as $tag)
                            <label class="flex items-center gap-3 cursor-pointer p-2 rounded-lg hover:bg-accent/30 transition">
                                <input type="checkbox" name="tags[]" value="{{ $tag->id }}" 
                                    {{ (collect(old('tags'))->contains($tag->id)) ? 'checked' : '' }}
                                    class="rounded border-ink/30 text-ink focus:ring-ink">
                                <span class="text-sm text-ink">#{{ $tag->name }}</span>
                            </label>
                        @endforeach
                    </div>
                    @error('tags') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                </div>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            if (typeof window.tinymce === 'undefined') {
                console.error('TinyMCE not loaded — cek resources/js/app.js');
                return;
            }

            const isDark = document.documentElement.classList.contains('dark');
            const bodyBg = isDark ? '#2A1F1B' : '#FFFFFF';
            const bodyColor = isDark ? '#F0E8DC' : '#3E2723';
            const codeBg = isDark ? '#1A120F' : '#F5F0E6';

            window.tinymce.init({
                selector: '#content',
                height: 560,
                menubar: false,
                branding: false,
                plugins: 'lists link code image',
                toolbar: 'undo redo | blocks | bold italic underline strikethrough | bullist numlist blockquote | link image | hr | code',
                skin: 'oxide',
                content_css: 'default',
                content_style: `
                    body {
                        font-family: 'Figtree', sans-serif;
                        background: ${bodyBg};
                        color: ${bodyColor};
                        font-size: 16px;
                        line-height: 1.8;
                        padding: 16px;
                    }
                    h1, h2, h3, h4 { font-family: 'Instrument Serif', serif; color: ${bodyColor}; }
                    blockquote { border-left: 3px solid #F4C9D6; padding-left: 16px; font-style: italic; }
                    a { color: ${bodyColor}; }
                    code { background: ${codeBg}; padding: 2px 6px; border-radius: 4px; font-size: 14px; }
                `,
                block_formats: 'Paragraph=p; Heading 1=h1; Heading 2=h2; Heading 3=h3; Heading 4=h4',
                valid_elements: 'p,br,strong,em,u,s,h1,h2,h3,h4,ul,ol,li,a[href|title|target],blockquote,code,pre,hr,img[src|alt|width|height]',
            });
        });
    </script>
@endsection