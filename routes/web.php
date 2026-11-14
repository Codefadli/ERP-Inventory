<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;

// ============================================================================
// PUBLIC ROUTES (Guest only)
// ============================================================================

// Route::get('/homepage', function () {
//     return view('dashboard-sebelum-login');
// })->name('dashboard-sebelum-login');

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
        Route::get('/', [App\Http\Controllers\ProfileController::class, 'show'])->name('show');
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
    Route::middleware('role:super_admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', function () {
            return view('dashboard.index');
        })->name('dashboard');

        Route::get('/notifikasi', [App\Http\Controllers\NotifikasiController::class, 'index'])
            ->name('notifikasi');
        
        Route::middleware('permission:user.manage')->group(function () {
            Route::get('/users', function () {
                return view('admin.users.index');
            })->name('users.index');
        });
        
        Route::middleware('permission:role.manage')->group(function () {
            Route::get('/roles', function () {
                return view('admin.roles.index');
            })->name('roles.index');
        });
        
        Route::middleware('permission:settings.manage')->group(function () {
            Route::get('/settings', function () {
                return view('admin.settings.index');
            })->name('settings.index');
        });
    });
    
    // ========================================================================
    // KEPALA GUDANG ROUTES
    // ========================================================================
    Route::middleware('role:kepala_gudang')->prefix('gudang')->name('gudang.')->group(function () {
        Route::get('/dashboard', function () {
            return view('dashboard.index');
        })->name('dashboard');

        Route::get('/notifikasi', [App\Http\Controllers\NotifikasiController::class, 'index'])
            ->name('notifikasi');
        
        Route::middleware('permission:master.manage')->group(function () {
            Route::get('/master/categories', function () {
                return view('gudang.master.categories');
            })->name('master.categories');
            
            Route::get('/master/locations', function () {
                return view('gudang.master.locations');
            })->name('master.locations');
        });
        
        Route::middleware('permission:product.manage')->group(function () {
            Route::get('/products', function () {
                return view('gudang.products.index');
            })->name('products.index');
        });
    });
    
    // ========================================================================
    // HR ROUTES (Approver)
    // ========================================================================
    Route::middleware('role:hr')->prefix('hr')->name('hr.')->group(function () {
        Route::get('/dashboard', function () {
            return view('dashboard.index');
        })->name('dashboard');

        Route::get('/notifikasi', [App\Http\Controllers\NotifikasiController::class, 'index'])
            ->name('notifikasi');
        
        Route::middleware('permission:issue.approve')->group(function () {
            Route::get('/approvals', function () {
                return view('hr.approvals.index');
            })->name('approvals.index');
        });
    });
    
    // ========================================================================
    // PEGAWAI GUDANG ROUTES
    // ========================================================================
    Route::middleware('role:pegawai')->prefix('pegawai')->name('pegawai.')->group(function () {
        Route::get('/dashboard', function () {
            return view('dashboard.index');
        })->name('dashboard');

        Route::get('/notifikasi', [App\Http\Controllers\NotifikasiController::class, 'index'])
            ->name('notifikasi');
        
        Route::middleware('permission:receipt.create')->group(function () {
            Route::get('/receipts', function () {
                return view('pegawai.receipts.index');
            })->name('receipts.index');
        });
        
        Route::middleware('permission:issue.create')->group(function () {
            Route::get('/issues', function () {
                return view('pegawai.issues.index');
            })->name('issues.index');
        });
    });
    
    // ========================================================================
    // AUDITOR ROUTES
    // ========================================================================
    Route::middleware('role:audit')->prefix('audit')->name('audit.')->group(function () {
        Route::get('/dashboard', function () {
            return view('dashboard.index');
        })->name('dashboard');

        Route::get('/notifikasi', [App\Http\Controllers\NotifikasiController::class, 'index'])
            ->name('notifikasi');
        
        Route::middleware('permission:audit.view')->group(function () {
            Route::get('/logs', function () {
                return view('audit.logs.index');
            })->name('logs.index');
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
    
    Route::get('/dashboard', function () {
        return view('dashboard.index');
    })->name('dashboard');

    Route::get('/notifikasi', [App\Http\Controllers\NotifikasiController::class, 'index'])
        ->name('notifikasi.index');
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

Route::fallback(function () {
    return response()->view('errors.403', [], 403);
});

