<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PengaturanController;
use App\Http\Controllers\UserManagementController;

// ============================================================================
// PUBLIC ROUTES (Guest only)
// ============================================================================

Route::get('/', function () {
    return view('dashboard-sebelum-login');
})->name('home');

Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.post');
});

// ============================================================================
// AUTHENTICATED ROUTES (Auth required)
// ============================================================================

Route::middleware('auth')->group(function () {

    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    Route::prefix('hub-selection')->name('hub.selection.')->group(function () {
        Route::get('/', [App\Http\Controllers\HubSelectionController::class, 'show'])->name('show');
        Route::post('/', [App\Http\Controllers\HubSelectionController::class, 'store'])->name('store');
        Route::get('/hubs-by-city', [App\Http\Controllers\HubSelectionController::class, 'getHubsByCity'])->name('hubs-by-city');
    });

    // ========================================================================
    // PROFILE ROUTES (All authenticated users)
    // ========================================================================
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/edit', [App\Http\Controllers\ProfileController::class, 'edit'])->name('edit');
        Route::put('/update', [App\Http\Controllers\ProfileController::class, 'update'])->name('update');
        Route::put('/email', [App\Http\Controllers\ProfileController::class, 'updateEmail'])->name('email');
        Route::put('/password', [App\Http\Controllers\ProfileController::class, 'updatePassword'])->name('password');
        Route::post('/photo', [App\Http\Controllers\ProfileController::class, 'uploadPhoto'])->name('photo.upload');
        Route::delete('/photo', [App\Http\Controllers\ProfileController::class, 'deletePhoto'])->name('photo.delete');
    });

    Route::get('/dashboard-redirect', function () {
        $user = auth()->user();

        if ($user->isSuperAdmin()) {
            return redirect()->route('admin.dashboard');
        }
        if ($user->isKepalaGudang()) {
            return redirect()->route('kepalagudang.dashboard');
        }
        if ($user->isHR()) {
            return redirect()->route('hr.dashboard');
        }
        if ($user->isPegawai()) {
            return redirect()->route('pegawai.dashboard');
        }
        if ($user->isAuditor()) {
            return redirect()->route('audit.dashboard');
        }

        return view('homepage.documentation');
    })->name('homepage');

    // ========================================================================
    // SUPER ADMIN ROUTES
    // ========================================================================
    Route::middleware('role:super_admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        Route::get('/notifikasi', [App\Http\Controllers\NotifikasiController::class, 'index'])
            ->name('notifikasi');

        Route::get('/pengaturan', [PengaturanController::class, 'index'])->name('pengaturan');
        Route::post('/pengaturan', [PengaturanController::class, 'update'])->name('pengaturan.update');
        Route::post('/pengaturan/reset', [PengaturanController::class, 'reset'])->name('pengaturan.reset');
        Route::get('/pengaturan/history', [PengaturanController::class, 'history'])->name('pengaturan.history');

        Route::get('/profile', [App\Http\Controllers\ProfilePageController::class, 'index'])
            ->name('profile');

        Route::get('/mutasi-barang', function () {
            return view('dashboard.mutasi-barang');
        })->name('mutasi-barang');

        Route::get('/barang-masuk', [App\Http\Controllers\TransaksiBarangController::class, 'masuk'])
            ->name('barang-masuk');

        Route::get('/barang-keluar', [App\Http\Controllers\TransaksiBarangController::class, 'keluar'])
            ->name('barang-keluar');

        Route::middleware('permission:user.manage')->group(function () {
            Route::get('/pengguna', [UserManagementController::class, 'index'])->name('pengguna');
            Route::post('/pengguna', [UserManagementController::class, 'store'])->name('pengguna.store');
            Route::put('/pengguna/{user}', [UserManagementController::class, 'update'])->name('pengguna.update');
            Route::post('/pengguna/{user}/toggle-status', [UserManagementController::class, 'toggleStatus'])->name('pengguna.toggle-status');
            Route::delete('/pengguna/{user}', [UserManagementController::class, 'destroy'])->name('pengguna.destroy');
            Route::post('/pengguna/bulk', [UserManagementController::class, 'bulk'])->name('pengguna.bulk');
            Route::get('/pengguna/export', [UserManagementController::class, 'export'])->name('pengguna.export');
            Route::get('/pengguna/{user}/activity', [UserManagementController::class, 'activity'])->name('pengguna.activity');
        });

        Route::middleware('permission:role.manage')->group(function () {
            Route::get('/roles', function () {
                return view('admin.roles.index');
            })->name('roles.index');
        });

        Route::middleware('permission:settings.manage')->group(function () {
            Route::get('/settings', function () {
                return redirect()->route('admin.pengaturan');
            })->name('settings.index');
        });

        Route::get('/persetujuan-barang', function () {
            return view('admin.persetujuan-barang');
        })->name('persetujuan-barang');

        Route::get('/data-gudang-lokasi', [App\Http\Controllers\MasterDataPageController::class, 'lokasi'])
            ->name('data-gudang-lokasi');

        Route::middleware('permission:audit.view')->group(function () {
            Route::get('/log-aktivitas', [App\Http\Controllers\LogAktivitasController::class, 'index'])
                ->name('log-aktivitas');
        });

        Route::middleware('permission:master.view')->group(function () {
            Route::get('/data-barang', [App\Http\Controllers\DataBarangController::class, 'index'])
                ->name('data-barang');

            Route::get('/data-departemen', [App\Http\Controllers\MasterDataPageController::class, 'departemen'])
                ->name('data-departemen');

            Route::get('/data-supplier', [App\Http\Controllers\MasterDataPageController::class, 'supplier'])
                ->name('data-supplier');

            Route::get('/kategori-barang', [App\Http\Controllers\MasterDataPageController::class, 'kategori'])
                ->name('kategori-barang');
        });

        Route::middleware('permission:master.manage')->group(function () {
            Route::post('/data-barang', [App\Http\Controllers\DataBarangController::class, 'store'])
                ->name('data-barang.store');
            Route::post('/data-gudang-lokasi', [App\Http\Controllers\MasterDataPageController::class, 'storeLokasi'])
                ->name('data-gudang-lokasi.store');
            Route::post('/data-departemen', [App\Http\Controllers\MasterDataPageController::class, 'storeDepartemen'])
                ->name('data-departemen.store');
            Route::post('/data-supplier', [App\Http\Controllers\MasterDataPageController::class, 'storeSupplier'])
                ->name('data-supplier.store');
            Route::post('/kategori-barang', [App\Http\Controllers\MasterDataPageController::class, 'storeKategori'])
                ->name('kategori-barang.store');
            Route::post('/barang-masuk', [App\Http\Controllers\TransaksiBarangController::class, 'storeMasuk'])
                ->name('barang-masuk.store');
            Route::post('/barang-keluar', [App\Http\Controllers\TransaksiBarangController::class, 'storeKeluar'])
                ->name('barang-keluar.store');
        });

        Route::middleware('permission:report.view')->group(function () {
            Route::get('/laporan-analitik', function () {
                return view('dashboard.superadmin.laporanAnalitik');
            })->name('laporan-analitik');

            Route::get('/laporan-riwayat', function () {
                return view('dashboard.superadmin.laporanRiwayat');
            })->name('laporan-riwayat');
        });
    });

    // ========================================================================
    // KEPALA GUDANG ROUTES
    // Prefix URL: /kepalagudang, nama route: kepalagudang.*
    // ========================================================================
    Route::middleware('role:kepala_gudang')->prefix('kepalagudang')->name('kepalagudang.')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        Route::get('/notifikasi', [App\Http\Controllers\NotifikasiController::class, 'index'])
            ->name('notifikasi');

        Route::get('/pengaturan', [PengaturanController::class, 'index'])->name('pengaturan');
        Route::post('/pengaturan', [PengaturanController::class, 'update'])->name('pengaturan.update');
        Route::post('/pengaturan/reset', [PengaturanController::class, 'reset'])->name('pengaturan.reset');
        Route::get('/pengaturan/history', [PengaturanController::class, 'history'])->name('pengaturan.history');

        Route::get('/profile', [App\Http\Controllers\ProfilePageController::class, 'index'])
            ->name('profile');

        Route::get('/mutasi-barang', function () {
            return view('dashboard.mutasi-barang');
        })->name('mutasi-barang');

        Route::get('/barang-masuk', [App\Http\Controllers\TransaksiBarangController::class, 'masuk'])
            ->name('barang-masuk');

        Route::get('/barang-keluar', [App\Http\Controllers\TransaksiBarangController::class, 'keluar'])
            ->name('barang-keluar');

        Route::get('/data-gudang-lokasi', [App\Http\Controllers\MasterDataPageController::class, 'lokasi'])
            ->name('data-gudang-lokasi');

        Route::get('/persetujuan-barang', [App\Http\Controllers\PersetujuanBarangController::class, 'index'])
            ->name('persetujuan-barang');
        Route::post('/persetujuan-barang/{id}/proses', [App\Http\Controllers\PersetujuanBarangController::class, 'proses'])
            ->name('persetujuan-barang.proses');

        Route::get('/mutasi-barang', [App\Http\Controllers\MutasiBarangController::class, 'index'])
            ->name('mutasi-barang');

        Route::get('/stok-opname', [App\Http\Controllers\StokOpnameController::class, 'index'])
            ->name('stok-opname');
        Route::post('/stok-opname', [App\Http\Controllers\StokOpnameController::class, 'store'])
            ->name('stok-opname.store');

        Route::middleware('permission:report.view')->group(function () {
            Route::get('/laporan', [App\Http\Controllers\LaporanKepalaGudangController::class, 'index'])
                ->name('laporan');
        });

        Route::middleware('permission:master.view')->group(function () {
            Route::get('/data-barang', [App\Http\Controllers\DataBarangController::class, 'index'])
                ->name('data-barang');
        });

        Route::middleware('permission:master.manage')->group(function () {
            Route::post('/data-barang', [App\Http\Controllers\DataBarangController::class, 'store'])
                ->name('data-barang.store');

            Route::post('/data-gudang-lokasi', [App\Http\Controllers\MasterDataPageController::class, 'storeLokasi'])
                ->name('data-gudang-lokasi.store');

            Route::post('/barang-masuk', [App\Http\Controllers\TransaksiBarangController::class, 'storeMasuk'])
                ->name('barang-masuk.store');

            Route::post('/barang-keluar', [App\Http\Controllers\TransaksiBarangController::class, 'storeKeluar'])
                ->name('barang-keluar.store');
        });
    });

    // ========================================================================
    // HR ROUTES (Approver)
    // ========================================================================
    Route::middleware('role:hr')->prefix('hr')->name('hr.')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        Route::get('/notifikasi', [App\Http\Controllers\NotifikasiController::class, 'index'])
            ->name('notifikasi');

        Route::get('/pengaturan', [PengaturanController::class, 'index'])->name('pengaturan');
        Route::post('/pengaturan', [PengaturanController::class, 'update'])->name('pengaturan.update');
        Route::post('/pengaturan/reset', [PengaturanController::class, 'reset'])->name('pengaturan.reset');
        Route::get('/pengaturan/history', [PengaturanController::class, 'history'])->name('pengaturan.history');

        Route::get('/profile', [App\Http\Controllers\ProfilePageController::class, 'index'])
            ->name('profile');

        Route::get('/mutasi-barang', function () {
            return view('dashboard.mutasi-barang');
        })->name('mutasi-barang');

        Route::get('/barang-masuk', [App\Http\Controllers\TransaksiBarangController::class, 'masuk'])
            ->name('barang-masuk');

        Route::get('/barang-keluar', [App\Http\Controllers\TransaksiBarangController::class, 'keluar'])
            ->name('barang-keluar');

        Route::get('/persetujuan-barang', [App\Http\Controllers\HrPageController::class, 'persetujuan'])
            ->name('persetujuan-barang');
        Route::post('/persetujuan-barang/{id}/proses', [App\Http\Controllers\HrPageController::class, 'proses'])
            ->name('persetujuan-barang.proses');

        Route::get('/detail-permintaan/{id}', [App\Http\Controllers\HrPageController::class, 'detail'])
            ->name('detail-permintaan');

        Route::get('/riwayat-persetujuan', [App\Http\Controllers\HrPageController::class, 'riwayat'])
            ->name('riwayat-persetujuan');

        Route::get('/laporan-inventaris', [App\Http\Controllers\HrPageController::class, 'laporan'])
            ->name('laporan-inventaris');

        Route::get('/log-audit-otorisasi', [App\Http\Controllers\LogAktivitasController::class, 'index'])
            ->name('log-audit-otorisasi');
    });

    // ========================================================================
    // PEGAWAI GUDANG ROUTES
    // ========================================================================
    Route::middleware('role:pegawai')->prefix('pegawai')->name('pegawai.')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        Route::get('/notifikasi', [App\Http\Controllers\NotifikasiController::class, 'index'])
            ->name('notifikasi');

        Route::get('/pengaturan', [PengaturanController::class, 'index'])->name('pengaturan');
        Route::post('/pengaturan', [PengaturanController::class, 'update'])->name('pengaturan.update');
        Route::post('/pengaturan/reset', [PengaturanController::class, 'reset'])->name('pengaturan.reset');
        Route::get('/pengaturan/history', [PengaturanController::class, 'history'])->name('pengaturan.history');

        Route::get('/profile', [App\Http\Controllers\ProfilePageController::class, 'index'])
            ->name('profile');

        Route::get('/mutasi-barang', function () {
            return view('dashboard.mutasi-barang');
        })->name('mutasi-barang');

        Route::get('/barang-masuk', [App\Http\Controllers\TransaksiBarangController::class, 'masuk'])
            ->name('barang-masuk');

        Route::get('/barang-keluar', [App\Http\Controllers\TransaksiBarangController::class, 'keluar'])
            ->name('barang-keluar');
        Route::middleware('permission:master.view')->group(function () {
            Route::get('/data-barang', [App\Http\Controllers\DataBarangController::class, 'index'])
                ->name('data-barang');
        });

        Route::get('/riwayat-transaksi', [App\Http\Controllers\PegawaiPageController::class, 'riwayat'])
            ->name('riwayat-transaksi');

        Route::get('/status-permintaan', [App\Http\Controllers\PegawaiPageController::class, 'permintaan'])
            ->name('status-permintaan');
        Route::post('/status-permintaan', [App\Http\Controllers\PegawaiPageController::class, 'storePermintaan'])
            ->name('status-permintaan.store');

        Route::get('/stok-opname', [App\Http\Controllers\PegawaiPageController::class, 'opname'])
            ->name('stok-opname');
        Route::post('/stok-opname', [App\Http\Controllers\PegawaiPageController::class, 'storeOpname'])
            ->name('stok-opname.store');
    });

    // ========================================================================
    // AUDITOR ROUTES
    // ========================================================================
    Route::middleware('role:audit')->prefix('audit')->name('audit.')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        Route::get('/notifikasi', [App\Http\Controllers\NotifikasiController::class, 'index'])
            ->name('notifikasi');

        Route::get('/pengaturan', [PengaturanController::class, 'index'])->name('pengaturan');
        Route::post('/pengaturan', [PengaturanController::class, 'update'])->name('pengaturan.update');
        Route::post('/pengaturan/reset', [PengaturanController::class, 'reset'])->name('pengaturan.reset');
        Route::get('/pengaturan/history', [PengaturanController::class, 'history'])->name('pengaturan.history');

        Route::get('/profile', [App\Http\Controllers\ProfilePageController::class, 'index'])
            ->name('profile');

        Route::get('/mutasi-barang', [App\Http\Controllers\MutasiBarangController::class, 'index'])
            ->name('mutasi-barang');

        Route::get('/barang-masuk', [App\Http\Controllers\TransaksiBarangController::class, 'masuk'])
            ->name('barang-masuk');

        Route::get('/barang-keluar', [App\Http\Controllers\TransaksiBarangController::class, 'keluar'])
            ->name('barang-keluar');

        Route::get('/stok-opname', [App\Http\Controllers\StokOpnameController::class, 'index'])
            ->name('stok-opname');

        Route::middleware('permission:audit.view')->group(function () {
            Route::get('/data-barang', [App\Http\Controllers\DataBarangController::class, 'index'])
                ->name('data-barang');

            Route::get('/temuan-audit', [App\Http\Controllers\TemuanAuditController::class, 'index'])
                ->name('temuan-audit');
            Route::post('/temuan-audit', [App\Http\Controllers\TemuanAuditController::class, 'store'])
                ->name('temuan-audit.store');
            Route::post('/temuan-audit/{id}/status', [App\Http\Controllers\TemuanAuditController::class, 'updateStatus'])
                ->name('temuan-audit.status');

            Route::get('/data-gudang-lokasi', [App\Http\Controllers\MasterDataPageController::class, 'lokasi'])
                ->name('data-gudang-lokasi');
        });
    });

    // ========================================================================
    // SHARED ROUTES (All authenticated users)
    // ========================================================================

    Route::middleware('permission:catalog.view')->group(function () {
        Route::get('/catalog', function () {
            return view('catalog.index');
        })->name('catalog.index');
    });

    Route::middleware('permission:report.view')->group(function () {
        Route::get('/reports', function () {
            return view('reports.index');
        })->name('reports.index');
    });

    Route::middleware('permission:transaction.view')->group(function () {
        Route::get('/transactions', function () {
            return view('transactions.index');
        })->name('transactions.index');
    });

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/notifikasi', [App\Http\Controllers\NotifikasiController::class, 'index'])
        ->name('notifikasi.index');

    Route::get('/pengaturan', [PengaturanController::class, 'index'])
        ->name('pengaturan.index');
    Route::post('/pengaturan', [PengaturanController::class, 'update'])
        ->name('pengaturan.update');
    Route::post('/pengaturan/reset', [PengaturanController::class, 'reset'])
        ->name('pengaturan.reset');
    Route::get('/pengaturan/history', [PengaturanController::class, 'history'])
        ->name('pengaturan.history');

    Route::get('/profile', [App\Http\Controllers\ProfilePageController::class, 'index'])
        ->name('profile.index');
});

Route::get('/documentation', function () {
    return view('homepage.documentation');
})->name('documentation');

// ============================================================================
// FALLBACK ROUTE
// ============================================================================
Route::fallback(function () {
    return response()->view('errors.404', [], 404);
});
