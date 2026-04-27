<?php

namespace App\Providers;

// Tus imports actuales
use App\Models\Maintenance;
use App\Models\Vehicle;
use App\Models\VehicleRequest;
use App\Policies\MaintenancePolicy;
use App\Policies\VehiclePolicy;
use App\Policies\VehicleRequestPolicy;

// --- NUEVOS IMPORTS PARA RUTAS ---
use App\Models\Route; 
use App\Policies\RoutePolicy;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Gate::policy(Vehicle::class, VehiclePolicy::class);
        Gate::policy(Maintenance::class, MaintenancePolicy::class);
        Gate::policy(VehicleRequest::class, VehicleRequestPolicy::class);
        Gate::policy(Route::class, RoutePolicy::class);

        Gate::before(function ($user, string $ability) {
            if ((int) $user->role_id === 1) {
                return true;
            }

            return null;
        });
    }
}