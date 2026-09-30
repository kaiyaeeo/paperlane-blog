@extends('layouts.paperlane')

@section('title', 'Edit Profil — Paperlane')

@section('content')
    <div class="w-full px-6 lg:px-12 py-12">
        <div class="max-w-2xl">
            <div class="mb-8">
                <h1 class="font-serif text-3xl md:text-4xl text-ink mb-2">Edit Profil</h1>
                <p class="text-ink/70">Perbarui informasi profil kamu.</p>
            </div>

            @if(session('success'))
                <div class="bg-accent text-ink px-4 py-3 rounded-lg mb-6 text-sm">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PUT')

                <!-- Avatar Preview -->
                <div class="flex items-center gap-6">
                    <img id="avatar-preview" src="{{ auth()->user()->avatar_url }}" alt="Avatar" class="w-20 h-20 rounded-full object-cover border-2 border-ink/10">
                    <div>
                        <label for="avatar" class="inline-block cursor-pointer text-sm px-4 py-2 border border-ink/20 rounded-full hover:bg-ink/5 transition text-ink">
                            Pilih Gambar
                        </label>
                        <input type="file" name="avatar" id="avatar" accept="image/*" class="hidden" onchange="previewAvatar(event)">
                        <p class="text-xs text-ink/50 mt-2">JPG, PNG, atau WebP. Maks 2MB.</p>
                        @error('avatar') <span class="text-red-600 text-sm block mt-1">{{ $message }}</span> @enderror
                    </div>
                </div>

                <!-- Nama -->
                <div>
                    <label class="block text-sm font-medium mb-2 text-ink">Nama</label>
                    <input type="text" name="name" value="{{ old('name', auth()->user()->name) }}" 
                        class="w-full bg-surface border-ink/20 rounded-lg shadow-sm focus:border-ink focus:ring-[#3E2723] text-ink">
                    @error('name') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- Bio -->
                <div>
                    <label class="block text-sm font-medium mb-2 text-ink">Bio</label>
                    <textarea name="bio" rows="4" maxlength="500"
                        placeholder="Ceritakan sedikit tentang dirimu..."
                        class="w-full bg-surface border-ink/20 rounded-lg shadow-sm focus:border-ink focus:ring-[#3E2723] text-ink">{{ old('bio', auth()->user()->bio) }}</textarea>
                    <p class="text-xs text-ink/50 mt-1">Maksimal 500 karakter.</p>
                    @error('bio') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- Action -->
                <div class="flex items-center gap-4 pt-2">
                    <button type="submit" class="px-6 py-2 bg-ink text-paper rounded-full hover:bg-ink/85 transition text-sm">
                        Simpan Perubahan
                    </button>
                    <a href="{{ route('profile.show', auth()->user()) }}" class="text-sm text-ink/70 hover:text-ink transition">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>

    <script>
        function previewAvatar(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    document.getElementById('avatar-preview').src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        }
    </script>
@endsection