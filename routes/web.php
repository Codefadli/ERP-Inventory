<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;

/*
|--------------------------------------------------------------------------
| Web Routes - ASTRO Inventory System
|--------------------------------------------------------------------------
*/

// ============================================================================
// PUBLIC ROUTES (Guest only)
// ============================================================================

Route::middleware('guest')->group(function () {
    // Login Routes
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.post');
});

// ============================================================================
// AUTHENTICATED ROUTES (Auth required)
// ============================================================================

Route::middleware('auth')->group(function () {
    
    // Logout
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    
    // Default Dashboard (redirect based on role)
    Route::get('/', function () {
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
        
        return view('dashboard.default');
    })->name('home');
    
    // ========================================================================
    // SUPER ADMIN ROUTES
    // ========================================================================
    Route::middleware('role:super_admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', function () {
            return view('dashboard.admin', ['user' => auth()->user()]);
        })->name('dashboard');
        
        // User Management (permission: user.manage)
        Route::middleware('permission:user.manage')->group(function () {
            Route::get('/users', function () {
                return view('admin.users.index');
            })->name('users.index');
        });
        
        // Role Management (permission: role.manage)
        Route::middleware('permission:role.manage')->group(function () {
            Route::get('/roles', function () {
                return view('admin.roles.index');
            })->name('roles.index');
        });
        
        // System Settings (permission: settings.manage)
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
            return view('dashboard.gudang', ['user' => auth()->user()]);
        })->name('dashboard');
        
        // Master Data (permission: master.manage)
        Route::middleware('permission:master.manage')->group(function () {
            Route::get('/master/categories', function () {
                return view('gudang.master.categories');
            })->name('master.categories');
            
            Route::get('/master/locations', function () {
                return view('gudang.master.locations');
            })->name('master.locations');
        });
        
        // Products (permission: product.manage)
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
            return view('dashboard.hr', ['user' => auth()->user()]);
        })->name('dashboard');
        
        // Approval Queue (permission: issue.approve)
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
            return view('dashboard.pegawai', ['user' => auth()->user()]);
        })->name('dashboard');
        
        // Barang Masuk (permission: receipt.create)
        Route::middleware('permission:receipt.create')->group(function () {
            Route::get('/receipts', function () {
                return view('pegawai.receipts.index');
            })->name('receipts.index');
        });
        
        // Barang Keluar (permission: issue.create)
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
            return view('dashboard.audit', ['user' => auth()->user()]);
        })->name('dashboard');
        
        // Audit Logs (permission: audit.view)
        Route::middleware('permission:audit.view')->group(function () {
            Route::get('/logs', function () {
                return view('audit.logs.index');
            })->name('logs.index');
        });
    });
    
    // ========================================================================
    // SHARED ROUTES (All authenticated users)
    // ========================================================================
    
    // View Catalog (permission: catalog.view)
    Route::middleware('permission:catalog.view')->group(function () {
        Route::get('/catalog', function () {
            return view('catalog.index');
        })->name('catalog.index');
    });
    
    // View Reports (permission: report.view)
    Route::middleware('permission:report.view')->group(function () {
        Route::get('/reports', function () {
            return view('reports.index');
        })->name('reports.index');
    });
    
    // View Transactions (permission: transaction.view)
    Route::middleware('permission:transaction.view')->group(function () {
        Route::get('/transactions', function () {
            return view('transactions.index');
        })->name('transactions.index');
    });
    
    // Default Dashboard (fallback)
    Route::get('/dashboard', function () {
        return view('dashboard.default', ['user' => auth()->user()]);
    })->name('dashboard');
});

// ============================================================================
// FALLBACK ROUTE
// ============================================================================
Route::fallback(function () {
    return response()->view('errors.404', [], 404);
});
