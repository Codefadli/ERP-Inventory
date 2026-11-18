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

        // Terapkan kebijakan timeout sesi dari tabel settings (bila tersedia).
        // Dibungkus try/catch agar aman saat migrasi/instalasi awal.
        try {
            if (Schema::hasTable('settings')) {
                $minutes = (int) \App\Models\Setting::query()
                    ->where('key', 'security.session_timeout_minutes')
                    ->where('scope', 'global')
                    ->where('scope_id', 0)
                    ->value('value');

                if ($minutes >= 5 && $minutes <= 480) {
                    config(['session.lifetime' => $minutes]);
                }
            }
        } catch (\Throwable $e) {
            // Tabel belum tersedia atau koneksi DB belum siap.
        }
    }
}
