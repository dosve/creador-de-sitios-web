<?php

namespace App\Policies;

use App\Models\MediaFile;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class MediaFilePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->isAdmin() || $user->isCreator();
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, MediaFile $mediaFile): bool
    {
        return $user->isAdmin() || $user->id === $mediaFile->website->user_id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->isAdmin() || $user->isCreator();
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, MediaFile $mediaFile): bool
    {
        return $user->isAdmin() || $user->id === $mediaFile->website->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, MediaFile $mediaFile): bool
    {
        return $user->isAdmin() || $user->id === $mediaFile->website->user_id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, MediaFile $mediaFile): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, MediaFile $mediaFile): bool
    {
        return false;
    }
}
