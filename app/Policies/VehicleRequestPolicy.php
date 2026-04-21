<?php

namespace App\Policies;

use App\Models\User;

class VehicleRequestPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, mixed $vehicleRequest): bool
    {
        $ownerId = data_get($vehicleRequest, 'user_id');

        return (int) $user->role_id === 1
            || (int) $user->role_id === 2
            || ((int) $user->role_id === 3 && (int) $user->id === (int) $ownerId);
    }

    public function create(User $user): bool
    {
        return (int) $user->role_id === 3;
    }

    public function update(User $user, mixed $vehicleRequest): bool
    {
        return in_array((int) $user->role_id, [1, 2], true);
    }

    public function delete(User $user, mixed $vehicleRequest): bool
    {
        $ownerId = data_get($vehicleRequest, 'user_id');

        return (int) $user->role_id === 3
            && (int) $user->id === (int) $ownerId;
    }

    public function restore(User $user, mixed $vehicleRequest): bool
    {
        return false;
    }

    public function forceDelete(User $user, mixed $vehicleRequest): bool
    {
        return false;
    }
}
