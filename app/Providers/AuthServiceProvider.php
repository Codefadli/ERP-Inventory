<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        // Define policies here if needed
    ];

    public function boot(): void
    {
        $this->registerPolicies();

        // Define permissions for roles
        Gate::before(function ($user, $ability) {
            if ($user->isSuperAdmin()) {
                return true; // Super admin can do anything
            }
        });

        // Permission gates
        Gate::define('view categories', function ($user) {
            return $user->hasPermission('master.view') || $user->isSuperAdmin();
        });

        Gate::define('manage categories', function ($user) {
            return $user->hasPermission('master.manage') || $user->isSuperAdmin();
        });

        Gate::define('view units', function ($user) {
            return $user->hasPermission('master.view') || $user->isSuperAdmin();
        });

        Gate::define('manage units', function ($user) {
            return $user->hasPermission('master.manage') || $user->isSuperAdmin();
        });

        Gate::define('view locations', function ($user) {
            return $user->hasPermission('master.view') || $user->isSuperAdmin();
        });

        Gate::define('manage locations', function ($user) {
            return $user->hasPermission('master.manage') || $user->isSuperAdmin();
        });

        Gate::define('view suppliers', function ($user) {
            return $user->hasPermission('master.view') || $user->isSuperAdmin();
        });

        Gate::define('manage suppliers', function ($user) {
            return $user->hasPermission('master.manage') || $user->isSuperAdmin();
        });

        Gate::define('view divisions', function ($user) {
            return $user->hasPermission('master.view') || $user->isSuperAdmin();
        });

        Gate::define('manage divisions', function ($user) {
            return $user->hasPermission('master.manage') || $user->isSuperAdmin();
        });

        Gate::define('view items', function ($user) {
            return $user->hasPermission('catalog.view') || $user->isSuperAdmin();
        });

        Gate::define('manage items', function ($user) {
            return $user->hasPermission('product.manage') || $user->isSuperAdmin();
        });

        Gate::define('delete items', function ($user) {
            return $user->hasPermission('master.delete') || $user->isSuperAdmin();
        });
    }
}