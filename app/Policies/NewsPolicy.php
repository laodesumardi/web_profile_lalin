<?php

namespace App\Policies;

use App\Models\News;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class NewsPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(?User $user): bool
    {
        // Allow public access to view news list
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(?User $user, News $news): bool
    {
        // Allow public access to view published news
        if ($news->is_published) {
            return true;
        }
        
        // Only allow authors, admins, or employees to view unpublished news
        return $user && ($user->id === $news->user_id || in_array($user->role, ['admin', 'pegawai']));
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        // Allow both admins and employees to create news
        return in_array($user->role, ['admin', 'pegawai']);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, News $news): bool
    {
        // Allow admins or the original author to update
        return $user->role === 'admin' || $user->id === $news->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, News $news): bool
    {
        // Only allow admins to delete
        return $user->role === 'admin';
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, News $news): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, News $news): bool
    {
        return false;
    }
}
