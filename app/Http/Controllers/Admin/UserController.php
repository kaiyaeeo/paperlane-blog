<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::withCount(['posts', 'comments'])
            ->latest()
            ->paginate(15);

        $stats = [
            'users' => User::count(),
            'posts' => Post::count(),
            'published' => Post::where('status', 'published')->count(),
            'drafts' => Post::where('status', 'draft')->count(),
        ];

        return view('admin.users.index', compact('users', 'stats'));
    }

    public function updateRole(Request $request, User $user)
    {
        $validated = $request->validate([
            'role' => 'required|in:admin,author',
        ]);

        // Cegah admin menghapus role dirinya sendiri
        if ($user->id === auth()->id() && $validated['role'] !== 'admin') {
            return back()->with('error', 'Kamu tidak bisa mengubah role dirimu sendiri.');
        }

        $user->update(['role' => $validated['role']]);

        return back()->with('success', 'Role user berhasil diperbarui!');
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Kamu tidak bisa menghapus akunmu sendiri.');
        }

        $user->delete();

        return back()->with('success', 'User berhasil dihapus.');
    }
}