<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;

class PostPolicy
{
    /**
     * Admin boleh melakukan apa saja.
     */
    public function before(User $user, string $ability): ?bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        return null;
    }

    /**
     * Apakah user boleh melihat daftar post di dashboard?
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Apakah user boleh melihat post tertentu?
     */
    public function view(User $user, Post $post): bool
    {
        return $user->id === $post->user_id;
    }

    /**
     * Apakah user boleh membuat post?
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Apakah user boleh mengedit post?
     */
    public function update(User $user, Post $post): bool
    {
        return $user->id === $post->user_id;
    }

    /**
     * Apakah user boleh menghapus post?
     */
    public function delete(User $user, Post $post): bool
    {
        return $user->id === $post->user_id;
    }
}