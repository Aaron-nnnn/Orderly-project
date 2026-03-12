<?php

namespace App\Policies;

use App\Models\Role;
use App\Models\User;

class RolePolicy
{
    /**
     * Only Admin can view all roles
     */
    public function viewAny(User $user): bool
    {
        return $user->role && $user->role->name === 'Admin';
    }

    /**
     * Only Admin can view a single role
     */
    public function view(User $user, Role $role): bool
    {
        return $user->role && $user->role->name === 'Admin';
    }

    /**
     * Only Admin can create roles
     */
    public function create(User $user): bool
    {
        return $user->role && $user->role->name === 'Admin';
    }

    /**
     * Only Admin can update roles
     */
    public function update(User $user, Role $role): bool
    {
        return $user->role && $user->role->name === 'Admin';
    }

    /**
     * Only Admin can delete roles
     */
    public function delete(User $user, Role $role): bool
    {
        return $user->role && $user->role->name === 'Admin';
    }
}
