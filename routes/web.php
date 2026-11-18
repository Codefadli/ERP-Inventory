<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;

// ============================================================================
// PUBLIC ROUTES (Guest only)
// ============================================================================

Route::get('/homepage', function () {
    return view('dashboard-sebelum-login');
})->name('dashboard-sebelum-login');



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

        Route::get('/edit', [App\Http\Controllers\ProfileController::class, 'edit'])
            ->name('edit');

        Route::put('/update', [App\Http\Controllers\ProfileController::class, 'update'])
            ->name('update');

        Route::put('/email', [App\Http\Controllers\ProfileController::class, 'updateEmail'])
            ->name('email');

        Route::put('/password', [App\Http\Controllers\ProfileController::class, 'updatePassword'])
            ->name('password');

        Route::post('/photo', [App\Http\Controllers\ProfileController::class, 'uploadPhoto'])
            ->name('photo.upload');

        Route::delete('/photo', [App\Http\Controllers\ProfileController::class, 'deletePhoto'])
            ->name('photo.delete');
    });

    // ========================================================================
    // DASHBOARD REDIRECT
    // ========================================================================

    Route::get('/dashboard-redirect', function () {

        $user = auth()->user();

        if ($user->isSuperAdmin()) {
            return redirect()->route('admin.dashboard');
        }

        if ($user->isKepalaGudang()) {
            return redirect()->route('gudang.dashboard');
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

    Route::middleware('role:super_admin')
        ->prefix('admin')
        ->name('admin.')
        ->group(function () {

            // DASHBOARD
            Route::get('/dashboard', function () {
                return view('dashboard.index');
            })->name('dashboard');

            // NOTIFIKASI
            Route::get('/notifikasi', [App\Http\Controllers\NotifikasiController::class, 'index'])
                ->name('notifikasi');

            // PENGATURAN
            Route::get('/pengaturan', [App\Http\Controllers\PengaturanController::class, 'index'])
                ->name('pengaturan');

            // PROFILE
            Route::get('/profile', [App\Http\Controllers\ProfilePageController::class, 'index'])
                ->name('profile');

            // LAPORAN INVENTARIS SUPER ADMIN
            Route::get('/laporan-inventaris', function () {
                return view('dashboard.hr.laporan-inventaris-hr');
            })->name('laporan-inventaris');

            // MANAJEMEN USER
            Route::middleware('permission:user.manage')->group(function () {

                Route::get('/users', function () {
                    return view('admin.users.index');
                })->name('users.index');
            });

            // MANAJEMEN ROLE
            Route::middleware('permission:role.manage')->group(function () {

                Route::get('/roles', function () {
                    return view('admin.roles.index');
                })->name('roles.index');
            });

            // PENGATURAN SISTEM
            Route::middleware('permission:settings.manage')->group(function () {

                Route::get('/settings', function () {
                    return view('admin.settings.index');
                })->name('settings.index');
            });

            // STOK OPNAME
            Route::get('/stok-opname', function () {
                return view('dashboard.stok-opname');
            })->name('stok-opname');

            // PERSETUJUAN BARANG
            Route::get('/persetujuan-barang', function () {
                return view('admin.persetujuan-barang');
            })->name('persetujuan-barang');

            // DATA GUDANG LOKASI
            Route::get('/data-gudang-lokasi', function () {
                return view('admin.data-gudang-lokasi');
            })->name('data-gudang-lokasi');
        });



    // ========================================================================
    // KEPALA GUDANG ROUTES
    // ========================================================================

    Route::middleware('role:kepala_gudang')
        ->prefix('gudang')
        ->name('gudang.')
        ->group(function () {

            // DASHBOARD
            Route::get('/dashboard', function () {
                return view('dashboard.index');
            })->name('dashboard');

            // NOTIFIKASI
            Route::get('/notifikasi', [App\Http\Controllers\NotifikasiController::class, 'index'])
                ->name('notifikasi');

            // PENGATURAN
            Route::get('/pengaturan', [App\Http\Controllers\PengaturanController::class, 'index'])
                ->name('pengaturan');

            // PROFILE
            Route::get('/profile', [App\Http\Controllers\ProfilePageController::class, 'index'])
                ->name('profile');

            // DATA GUDANG LOKASI
            Route::get('/data-gudang-lokasi', function () {
                return view('gudang.data-gudang-lokasi');
            })->name('data-gudang-lokasi');

            // PERSETUJUAN BARANG
            Route::get('/persetujuan-barang', function () {
                return view('gudang.persetujuan-barang');
            })->name('persetujuan-barang');


            Route::get('/stok-opname', function () {
                return view('dashboard.stok-opname');
            })->name('stok-opname');

            // MASTER DATA
            Route::middleware('permission:master.manage')->group(function () {

                Route::get('/master/categories', function () {
                    return view('gudang.master.categories');
                })->name('master.categories');

                Route::get('/master/locations', function () {
                    return view('gudang.master.locations');
                })->name('master.locations');
            });

            // DATA PRODUK
            Route::middleware('permission:product.manage')->group(function () {

                Route::get('/products', function () {
                    return view('gudang.products.index');
                })->name('products.index');
            });
        });


    // ========================================================================
    // HR ROUTES (Approver)
    // ========================================================================

    Route::middleware('role:hr')
        ->prefix('hr')
        ->name('hr.')
        ->group(function () {

            // DASHBOARD
            Route::get('/dashboard', function () {
                return view('dashboard.index');
            })->name('dashboard');

            // NOTIFIKASI
            Route::get('/notifikasi', [App\Http\Controllers\NotifikasiController::class, 'index'])
                ->name('notifikasi');

            // PENGATURAN
            Route::get('/pengaturan', [App\Http\Controllers\PengaturanController::class, 'index'])
                ->name('pengaturan');

            // PROFILE
            Route::get('/profile', [App\Http\Controllers\ProfilePageController::class, 'index'])
                ->name('profile');

            // PERSETUJUAN BARANG
            Route::get('/persetujuan-barang', function () {
                return view('dashboard.hr.persetujuan-barang');
            })->name('persetujuan-barang');

            // RIWAYAT PERSETUJUAN
            Route::get('/riwayat-persetujuan', function () {
                return view('dashboard.hr.riwayat-persetujuan');
            })->name('riwayat-persetujuan');

            // LAPORAN INVENTARIS HR
            Route::get('/laporan-inventaris', function () {
                return view('dashboard.hr.laporan-inventaris-hr');
            })->name('laporan-inventaris');

            // LOG AUDIT & OTORISASI
            Route::get('/logs', function () {
                return view('dashboard.hr.log-audit-otorisasi');
            })->name('logs.index');

            // PERSETUJUAN BERDASARKAN PERMISSION
            Route::middleware('permission:issue.approve')->group(function () {

                Route::get('/approvals', function () {
                    return view('hr.approvals.index');
                })->name('approvals.index');
            });
        });


    // ========================================================================
    // PEGAWAI GUDANG ROUTES
    // ========================================================================

    Route::middleware('role:pegawai')
        ->prefix('pegawai')
        ->name('pegawai.')
        ->group(function () {

            // DASHBOARD
            Route::get('/dashboard', function () {
                return view('dashboard.index');
            })->name('dashboard');

            // NOTIFIKASI
            Route::get('/notifikasi', [App\Http\Controllers\NotifikasiController::class, 'index'])
                ->name('notifikasi');

            // PENGATURAN
            Route::get('/pengaturan', [App\Http\Controllers\PengaturanController::class, 'index'])
                ->name('pengaturan');

            // PROFILE
            Route::get('/profile', [App\Http\Controllers\ProfilePageController::class, 'index'])
                ->name('profile');

            // BARANG MASUK
            Route::middleware('permission:receipt.create')->group(function () {

                Route::get('/receipts', function () {
                    return view('pegawai.receipts.index');
                })->name('receipts.index');
            });


            Route::get('/stok-opname', function () {
                return view('dashboard.stok-opname');
            })->name('stok-opname');

            // BARANG KELUAR
            Route::middleware('permission:issue.create')->group(function () {

                Route::get('/issues', function () {
                    return view('pegawai.issues.index');
                })->name('issues.index');
            });
        });


    // ========================================================================
    // AUDITOR ROUTES
    // ========================================================================

    Route::middleware('role:audit')
        ->prefix('audit')
        ->name('audit.')
        ->group(function () {

            // DASHBOARD
            Route::get('/dashboard', function () {
                return view('dashboard.index');
            })->name('dashboard');

            // NOTIFIKASI
            Route::get('/notifikasi', [App\Http\Controllers\NotifikasiController::class, 'index'])
                ->name('notifikasi');

            // PENGATURAN
            Route::get('/pengaturan', [App\Http\Controllers\PengaturanController::class, 'index'])
                ->name('pengaturan');

            // PROFILE
            Route::get('/profile', [App\Http\Controllers\ProfilePageController::class, 'index'])
                ->name('profile');

            // FITUR AUDIT
            Route::middleware('permission:audit.view')->group(function () {

                Route::get('/temuan-audit', function () {
                    return view('dashboard.audit.temuan-audit');
                })->name('temuan-audit');

                Route::get('/data-gudang-lokasi', function () {
                    return view('dashboard.audit.data-gudang-lokasi');
                })->name('data-gudang-lokasi');

                Route::get('/logs', function () {
                    return view('audit.logs.index');
                })->name('logs.index');

                Route::get('/stok-opname', function () {
                    return view('dashboard.stok-opname');
                })->name('stok-opname');
            });
        });


    // ========================================================================
    // SHARED ROUTES (All authenticated users)
    // ========================================================================

    // KATALOG
    Route::middleware('permission:catalog.view')->group(function () {

        Route::get('/catalog', function () {
            return view('catalog.index');
        })->name('catalog.index');
    });

    // LAPORAN UMUM
    Route::middleware('permission:report.view')->group(function () {

        Route::get('/reports', function () {
            return view('reports.index');
        })->name('reports.index');
    });

    // TRANSAKSI
    Route::middleware('permission:transaction.view')->group(function () {

        Route::get('/transactions', function () {
            return view('transactions.index');
        })->name('transactions.index');
    });

    // DASHBOARD UMUM
    Route::get('/dashboard', function () {
        return view('dashboard.index');
    })->name('dashboard');

    // NOTIFIKASI UMUM
    Route::get('/notifikasi', [App\Http\Controllers\NotifikasiController::class, 'index'])
        ->name('notifikasi.index');

    // PENGATURAN UMUM
    Route::get('/pengaturan', [App\Http\Controllers\PengaturanController::class, 'index'])
        ->name('pengaturan.index');

    // PROFILE UMUM
    Route::get('/profile', [App\Http\Controllers\ProfilePageController::class, 'index'])
        ->name('profile.index');
});


// ============================================================================
// DOCUMENTATION
// ============================================================================

Route::get('/documentation', function () {
    return view('homepage.documentation');
})->name('documentation');


// ============================================================================
// FALLBACK ROUTE
// ============================================================================

Route::fallback(function () {
    return response()->view('errors.404', [], 404);
});
