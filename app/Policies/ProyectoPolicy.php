<?php

namespace App\Policies;

use App\Models\Proyecto;
use App\Models\User;

class ProyectoPolicy
{
    /**
     * Anyone can view the list of projects.
     */
    public function viewAny(?User $user): bool
    {
        return true;
    }

    /**
     * Anyone can view a single project.
     */
    public function view(?User $user, Proyecto $proyecto): bool
    {
        return true;
    }

    /**
     * Any authenticated user can create projects.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Only the project owner can update it.
     */
    public function update(User $user, Proyecto $proyecto): bool
    {
        return $user->id === $proyecto->user_id;
    }

    /**
     * Only the project owner can delete it.
     */
    public function delete(User $user, Proyecto $proyecto): bool
    {
        return $user->id === $proyecto->user_id;
    }
}
