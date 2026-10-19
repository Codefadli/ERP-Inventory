<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

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
        // Fix MySQL key length error (767 bytes limit)
        // 191 chars × 4 bytes (utf8mb4) = 764 bytes < 767 bytes ✓
        Schema::defaultStringLength(191);
    }
}
