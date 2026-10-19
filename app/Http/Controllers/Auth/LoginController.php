<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    /**
     * Tampilkan halaman login
     */
    public function showLoginForm()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }

        return view('auth.login');
    }

    /**
     * Proses login
     * 
     * Security Features (SR-ASTRO-001, SR-ASTRO-002):
     * - Rate limiting: 5x gagal = lock 15 menit
     * - Pesan error generik (tidak bedakan user tidak ada vs password salah)
     * - Password verification dengan hash
     * - Update last login info
     */
    public function login(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'login' => 'required|string',
            'password' => 'required|string',
        ], [
            'login.required' => 'Email atau username wajib diisi',
            'password.required' => 'Password wajib diisi',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput($request->only('login'));
        }

        // Cari user berdasarkan email atau username
        $user = User::where('email', $request->login)
            ->orWhere('username', $request->login)
            ->first();

        // Pesan error generik (SR-ASTRO-001)
        $genericErrorMessage = 'Email/username atau password salah.';

        // User tidak ditemukan
        if (!$user) {
            return back()
                ->withErrors(['login' => $genericErrorMessage])
                ->withInput($request->only('login'));
        }

        // Check apakah akun aktif (FR-ASTRO-003)
        if ($user->status !== 'active') {
            return back()
                ->withErrors(['login' => 'Akun Anda tidak aktif. Silakan hubungi administrator.'])
                ->withInput($request->only('login'));
        }

        // Check apakah akun terkunci (SR-ASTRO-001)
        if ($user->isLocked()) {
            $lockedUntil = $user->locked_until->timezone('Asia/Jakarta')->format('H:i:s');
            return back()
                ->withErrors(['login' => "Akun terkunci karena terlalu banyak percobaan login gagal. Coba lagi setelah {$lockedUntil}."])
                ->withInput($request->only('login'));
        }

        // Verifikasi password
        if (!Hash::check($request->password, $user->password)) {
            // Increment failed login attempts
            $user->incrementLoginAttempts();

            // Check jika sekarang terkunci
            if ($user->isLocked()) {
                $lockedUntil = $user->locked_until->timezone('Asia/Jakarta')->format('H:i:s');
                return back()
                    ->withErrors(['login' => "Akun terkunci karena 5 kali percobaan login gagal. Coba lagi setelah {$lockedUntil}."])
                    ->withInput($request->only('login'));
            }

            return back()
                ->withErrors(['login' => $genericErrorMessage])
                ->withInput($request->only('login'));
        }

        // Login berhasil
        // Reset failed attempts
        $user->resetLoginAttempts();

        // Update last login info
        $user->updateLastLogin($request->ip());

        // Login user
        Auth::login($user, $request->filled('remember'));

        // Regenerate session untuk keamanan (SR-ASTRO-005)
        $request->session()->regenerate();

        // Log audit trail
        \Log::info('User login', [
            'user_id' => $user->id,
            'username' => $user->username,
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        // Redirect berdasarkan role
        return $this->redirectAfterLogin($user);
    }

    /**
     * Redirect setelah login berdasarkan role
     */
    protected function redirectAfterLogin(User $user)
    {
        if ($user->isSuperAdmin()) {
            return redirect()->route('admin.dashboard')->with('success', 'Selamat datang, ' . $user->nama_lengkap);
        }

        if ($user->isKepalaGudang()) {
            return redirect()->route('gudang.dashboard')->with('success', 'Selamat datang, ' . $user->nama_lengkap);
        }

        if ($user->isHR()) {
            return redirect()->route('hr.dashboard')->with('success', 'Selamat datang, ' . $user->nama_lengkap);
        }

        if ($user->isPegawai()) {
            return redirect()->route('pegawai.dashboard')->with('success', 'Selamat datang, ' . $user->nama_lengkap);
        }

        if ($user->isAuditor()) {
            return redirect()->route('audit.dashboard')->with('success', 'Selamat datang, ' . $user->nama_lengkap);
        }

        // Default redirect
        return redirect()->route('dashboard')->with('success', 'Selamat datang, ' . $user->nama_lengkap);
    }

    /**
     * Logout
     */
    public function logout(Request $request)
    {
        $user = Auth::user();

        // Log audit trail
        if ($user) {
            \Log::info('User logout', [
                'user_id' => $user->id,
                'username' => $user->username,
                'ip' => $request->ip(),
            ]);
        }

        // Logout
        Auth::logout();

        // Invalidate session (SR-ASTRO-005)
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Anda telah berhasil logout.');
    }
}
