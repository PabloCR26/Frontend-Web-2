<?php

namespace App\Providers;

use App\Models\Maintenance;
use App\Models\Vehicle;
use App\Models\VehicleRequest;
use App\Policies\MaintenancePolicy;
use App\Policies\VehiclePolicy;
use App\Policies\VehicleRequestPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::policy(Vehicle::class, VehiclePolicy::class);
        Gate::policy(Maintenance::class, MaintenancePolicy::class);
        Gate::policy(VehicleRequest::class, VehicleRequestPolicy::class);

        Gate::before(function ($user, string $ability) {
            if ((int) $user->role_id === 1) {
                return true;
            }

            return null;
        });
    }
}
