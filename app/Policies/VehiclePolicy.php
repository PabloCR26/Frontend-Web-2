<?php

namespace App\Policies;

use App\Models\User;

class VehiclePolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, mixed $vehicle): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return (int) $user->role_id === 1;
    }

    public function update(User $user, mixed $vehicle): bool
    {
        return (int) $user->role_id === 1;
    }

    public function delete(User $user, mixed $vehicle): bool
    {
        return (int) $user->role_id === 1;
    }

    public function restore(User $user, mixed $vehicle): bool
    {
        return (int) $user->role_id === 1;
    }

    public function forceDelete(User $user, mixed $vehicle): bool
    {
        return (int) $user->role_id === 1;
    }
}
