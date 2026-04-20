<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;

class PostPolicy
{
    // List (/posts)
    public function viewAny(User $user): bool
    {
        return true; 
    }

    // Single view (/posts/{id})
    public function view(User $user, Post $post): bool
    {
        return true; 
    }

    // Create
    public function create(User $user): bool
    {
        return $user->role !== 'viewer';
    }

    // Update
    public function update(User $user, Post $post): bool
    {
        
        if ($user->role === 'admin') {
            return true;
        }

        
        if ($user->role === 'editor' && $post->user_id === $user->id) {
            return true;
        }

        return false;
    }

    // Delete
    public function delete(User $user, Post $post): bool
    {
        return $user->role === 'admin';
    }
}