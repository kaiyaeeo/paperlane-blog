<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Like;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    /**
     * Profil publik author.
     */
    public function show(User $user)
    {
        $posts = Post::with(['category', 'tags', 'likes', 'comments'])
            ->where('user_id', $user->id)
            ->where('status', 'published')
            ->latest()
            ->paginate(9);

        $stats = [
            'posts' => Post::where('user_id', $user->id)->where('status', 'published')->count(),
            'likes' => Like::whereHas('post', function ($q) use ($user) {
                $q->where('user_id', $user->id);
            })->count(),
            'comments' => Comment::whereHas('post', function ($q) use ($user) {
                $q->where('user_id', $user->id);
            })->count(),
        ];

        return view('profile.show', compact('user', 'posts', 'stats'));
    }

    /**
     * Form edit profil user sendiri (Breeze).
     */
    public function edit(Request $request)
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Simpan perubahan profil.
     */
    public function update(Request $request)
    {
        $user = $request->user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique(User::class)->ignore($user->id)],
            'bio' => 'nullable|string|max:500',
            'avatar' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($request->hasFile('avatar')) {
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }

            $validated['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        $user->fill($validated);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        return redirect()->route('profile.show', $user)
            ->with('success', 'Profil berhasil diperbarui!');
    }

    /**
     * Hapus akun user (Breeze).
     */
    public function destroy(Request $request)
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}