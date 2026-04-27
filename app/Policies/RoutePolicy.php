<?php

namespace App\Policies;

use App\Models\User;

class RoutePolicy
{
    public function viewAny(User $user): bool
    {
        return in_array($user->role_id, [1, 2]);
    }

    public function view(User $user): bool
    {
        return in_array($user->role_id, [1, 2]);
    }

    public function create(User $user): bool
    {
        return in_array($user->role_id, [1, 2]);
    }

    public function update(User $user): bool
    {
        return in_array($user->role_id, [1, 2]);
    }

    public function delete(User $user): bool
    {
        return $user->role_id === 1; 
    }

    public function restore(User $user): bool
    {
        return $user->role_id === 1;
    }
}