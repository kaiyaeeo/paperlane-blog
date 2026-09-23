@extends('layouts.paperlane')

@section('title', 'Buat Post Baru - Paperlane')

@section('content')
    <div class="max-w-2xl mx-auto px-4 py-8">
        <h1 class="text-2xl font-bold mb-6">Buat Post Baru</h1>

        <form action="{{ route('posts.store') }}" method="POST" class="space-y-4">
            @csrf

            <div>
                <label class="block text-sm font-medium mb-1">Judul</label>
                <input type="text" name="title" value="{{ old('title') }}" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-gray-500 focus:ring-gray-500">
                @error('title') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Konten</label>
                <textarea name="content" rows="6" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-gray-500 focus:ring-gray-500">{{ old('content') }}</textarea>
                @error('content') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Status</label>
                <select name="status" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-gray-500 focus:ring-gray-500">
                    <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                    <option value="published" {{ old('status') == 'published' ? 'selected' : '' }}>Published</option>
                </select>
                @error('status') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <button type="submit" class="px-6 py-2 bg-gray-900 text-white rounded-lg hover:bg-gray-700 transition">
                Simpan Post
            </button>
        </form>
    </div>
@endsection