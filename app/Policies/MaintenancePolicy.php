<?php

namespace App\Policies;

use App\Models\User;

class MaintenancePolicy
{
    public function viewAny(User $user): bool
    {
        return in_array((int) $user->role_id, [1, 2], true);
    }

    public function view(User $user, mixed $maintenance): bool
    {
        return in_array((int) $user->role_id, [1, 2], true);
    }

    public function create(User $user): bool
    {
        return in_array((int) $user->role_id, [1, 2], true);
    }

    public function update(User $user, mixed $maintenance): bool
    {
        return in_array((int) $user->role_id, [1, 2], true);
    }

    public function delete(User $user, mixed $maintenance): bool
    {
        return in_array((int) $user->role_id, [1, 2], true);
    }

    public function restore(User $user, mixed $maintenance): bool
    {
        return false;
    }

    public function forceDelete(User $user, mixed $maintenance): bool
    {
        return false;
    }
}
