@extends('layouts.paperlane')

@section('title', 'Edit Post - Paperlane')

@section('content')
    <div class="w-full px-6 lg:px-12 py-12">
        <div class="max-w-3xl">
            <h1 class="font-serif text-3xl md:text-4xl text-[#3E2723] mb-8">Edit Post</h1>

            <form action="{{ route('posts.update', $post) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <div>
                    <label class="block text-sm font-medium mb-2 text-[#3E2723]">Judul</label>
                    <input type="text" name="title" value="{{ old('title', $post->title) }}" 
                        class="w-full bg-white border-[#3E2723]/20 rounded-lg shadow-sm focus:border-[#3E2723] focus:ring-[#3E2723] text-[#3E2723]">
                    @error('title') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium mb-2 text-[#3E2723]">Konten</label>
                    <textarea name="content" id="content" rows="10" 
                        class="w-full bg-white border-[#3E2723]/20 rounded-lg shadow-sm focus:border-[#3E2723] focus:ring-[#3E2723] text-[#3E2723]">{{ old('content', $post->content) }}</textarea>
                    @error('content') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium mb-2 text-[#3E2723]">Kategori</label>
                    <select name="category_id" class="w-full bg-white border-[#3E2723]/20 rounded-lg shadow-sm focus:border-[#3E2723] focus:ring-[#3E2723] text-[#3E2723]">
                        <option value="">-- Pilih Kategori --</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id', $post->category_id) == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium mb-2 text-[#3E2723]">Tag</label>
                    <select name="tags[]" multiple class="w-full bg-white border-[#3E2723]/20 rounded-lg shadow-sm focus:border-[#3E2723] focus:ring-[#3E2723] text-[#3E2723] h-32">
                        @foreach($tags as $tag)
                            <option value="{{ $tag->id }}" {{ (collect(old('tags', $post->tags->pluck('id')))->contains($tag->id)) ? 'selected' : '' }}>
                                {{ $tag->name }}
                            </option>
                        @endforeach
                    </select>
                    <p class="text-xs text-[#3E2723]/50 mt-1">Tahan Ctrl (Windows) atau Cmd (Mac) untuk memilih lebih dari satu tag.</p>
                    @error('tags') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium mb-2 text-[#3E2723]">Status</label>
                    <select name="status" class="w-full bg-white border-[#3E2723]/20 rounded-lg shadow-sm focus:border-[#3E2723] focus:ring-[#3E2723] text-[#3E2723]">
                        <option value="draft" {{ old('status', $post->status) == 'draft' ? 'selected' : '' }}>Draft</option>
                        <option value="published" {{ old('status', $post->status) == 'published' ? 'selected' : '' }}>Published</option>
                    </select>
                    @error('status') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="flex items-center gap-4 pt-2">
                    <button type="submit" class="px-6 py-2 bg-[#3E2723] text-[#F5F0E6] rounded-full hover:bg-[#3E2723]/85 transition text-sm">
                        Update Post
                    </button>
                    <a href="{{ route('posts.index') }}" class="text-sm text-[#3E2723]/70 hover:text-[#3E2723] transition">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- TinyMCE -->
    <script src="https://cdn.jsdelivr.net/npm/tinymce@7/tinymce.min.js" referrerpolicy="origin"></script>
    <script>
        tinymce.init({
            selector: '#content',
            height: 500,
            menubar: false,
            branding: false,
            plugins: 'lists link code blockquote hr image',
            toolbar: 'undo redo | blocks | bold italic underline strikethrough | bullist numlist blockquote | link image | hr | code',
            skin: 'oxide',
            content_css: 'default',
            content_style: `
                body {
                    font-family: 'Figtree', sans-serif;
                    color: #3E2723;
                    font-size: 16px;
                    line-height: 1.8;
                    padding: 16px;
                }
                h1, h2, h3, h4 { font-family: 'Instrument Serif', serif; color: #3E2723; }
                blockquote { border-left: 3px solid #F4C9D6; padding-left: 16px; color: #3E2723; font-style: italic; }
                a { color: #3E2723; }
                code { background: #F5F0E6; padding: 2px 6px; border-radius: 4px; font-size: 14px; }
            `,
            block_formats: 'Paragraph=p; Heading 1=h1; Heading 2=h2; Heading 3=h3; Heading 4=h4',
            valid_elements: 'p,br,strong,em,u,s,h1,h2,h3,h4,ul,ol,li,a[href|title|target],blockquote,code,pre,hr,img[src|alt|width|height]',
        });
    </script>
@endsection