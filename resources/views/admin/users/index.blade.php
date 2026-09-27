@extends('layouts.paperlane')

@section('title', 'Kelola User — Paperlane')

@section('content')
    <div class="w-full px-6 lg:px-12 py-12">
        <div class="mb-8">
            <h1 class="font-serif text-3xl md:text-4xl text-[#3E2723] mb-2">Kelola User</h1>
            <p class="text-[#3E2723]/70">Manajemen user dan statistik Paperlane.</p>
        </div>

        <!-- Statistik -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-10">
            <div class="bg-[#F4C9D6]/40 rounded-lg p-4">
                <div class="text-xs text-[#3E2723]/60 uppercase tracking-widest mb-1">Total User</div>
                <div class="font-serif text-3xl text-[#3E2723]">{{ $stats['users'] }}</div>
            </div>
            <div class="bg-[#F4C9D6]/40 rounded-lg p-4">
                <div class="text-xs text-[#3E2723]/60 uppercase tracking-widest mb-1">Total Post</div>
                <div class="font-serif text-3xl text-[#3E2723]">{{ $stats['posts'] }}</div>
            </div>
            <div class="bg-[#F4C9D6]/40 rounded-lg p-4">
                <div class="text-xs text-[#3E2723]/60 uppercase tracking-widest mb-1">Published</div>
                <div class="font-serif text-3xl text-[#3E2723]">{{ $stats['published'] }}</div>
            </div>
            <div class="bg-[#F4C9D6]/40 rounded-lg p-4">
                <div class="text-xs text-[#3E2723]/60 uppercase tracking-widest mb-1">Draft</div>
                <div class="font-serif text-3xl text-[#3E2723]">{{ $stats['drafts'] }}</div>
            </div>
        </div>

        @if(session('success'))
            <div class="bg-[#F4C9D6] text-[#3E2723] px-4 py-3 rounded-lg mb-6 text-sm max-w-md">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 text-red-800 px-4 py-3 rounded-lg mb-6 text-sm max-w-md">
                {{ session('error') }}
            </div>
        @endif

        <!-- Tabel User -->
        <div class="bg-white rounded-lg border border-[#3E2723]/10 overflow-hidden">
            <table class="w-full text-sm">
                <thead class="bg-[#3E2723]/5 text-[#3E2723]/70 text-xs uppercase tracking-widest">
                    <tr>
                        <th class="text-left px-4 py-3">User</th>
                        <th class="text-left px-4 py-3 hidden md:table-cell">Email</th>
                        <th class="text-center px-4 py-3">Post</th>
                        <th class="text-center px-4 py-3 hidden md:table-cell">Komentar</th>
                        <th class="text-left px-4 py-3">Role</th>
                        <th class="text-right px-4 py-3">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                        <tr class="border-t border-[#3E2723]/10 hover:bg-[#F5F0E6]/50">
                            <td class="px-4 py-3">
                                <div class="flex items-center gap-3">
                                    <img src="{{ $user->avatar_url }}" alt="" class="w-8 h-8 rounded-full object-cover">
                                    <div>
                                        <div class="font-medium text-[#3E2723]">{{ $user->name }}</div>
                                        @if($user->id === auth()->id())
                                            <div class="text-xs text-[#3E2723]/50">(kamu)</div>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-3 text-[#3E2723]/70 hidden md:table-cell">{{ $user->email }}</td>
                            <td class="px-4 py-3 text-center text-[#3E2723]">{{ $user->posts_count }}</td>
                            <td class="px-4 py-3 text-center text-[#3E2723] hidden md:table-cell">{{ $user->comments_count }}</td>
                            <td class="px-4 py-3">
                                <form action="{{ route('admin.users.updateRole', $user) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <select name="role" onchange="this.form.submit()" 
                                        class="text-xs bg-white border-[#3E2723]/20 rounded-lg focus:border-[#3E2723] focus:ring-[#3E2723] text-[#3E2723] py-1 pl-2 pr-6">
                                        <option value="author" {{ $user->role === 'author' ? 'selected' : '' }}>Author</option>
                                        <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
                                    </select>
                                </form>
                            </td>
                            <td class="px-4 py-3 text-right">
                                @if($user->id !== auth()->id())
                                    <form action="{{ route('admin.users.destroy', $user) }}" method="POST" onsubmit="return confirm('Hapus user ini? Semua post & komentarnya akan ikut terhapus.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-xs text-red-600 hover:text-red-800 transition">
                                            Hapus
                                        </button>
                                    </form>
                                @else
                                    <span class="text-xs text-[#3E2723]/30">—</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-8">
            {{ $users->links() }}
        </div>
    </div>
@endsection