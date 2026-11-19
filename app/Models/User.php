<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'username',
        'email',
        'password',
        'nama_lengkap',
        'nip',
        'phone',
        'profile_photo',
        'role_id',
        'division_id',
        'selected_city_id',
        'selected_hub_id',
        'status',
        'failed_login_attempts',
        'locked_until',
        'last_login_at',
        'last_login_ip',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'locked_until' => 'datetime',
        'last_login_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Relasi: User memiliki satu Role
     */
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * Relasi: User memiliki satu Divisi
     */
    public function division()
    {
        return $this->belongsTo(Division::class, 'division_id');
    }

    /**
     * Relasi: User memiliki banyak Token
     */
    public function tokens()
    {
        return $this->hasMany(UserToken::class);
    }

    /**
     * Relasi: Registry sesi perangkat pengguna
     */
    public function sessions()
    {
        return $this->hasMany(UserSession::class);
    }

    /**
     * Relasi: Jejak audit pengguna
     */
    public function auditLogs()
    {
        return $this->hasMany(AuditLog::class);
    }

    /**
     * Relasi: User belongs to selected City
     */
    public function selectedCity()
    {
        return $this->belongsTo(City::class, 'selected_city_id');
    }

    /**
     * Relasi: User belongs to selected Hub
     */
    public function selectedHub()
    {
        return $this->belongsTo(Hub::class, 'selected_hub_id');
    }

    /**
     * Check apakah user memiliki permission tertentu
     */
    public function hasPermission(string $permissionCode): bool
    {
        return $this->role && $this->role->hasPermission($permissionCode);
    }

    /**
     * Check apakah user memiliki salah satu dari permission yang diberikan
     */
    public function hasAnyPermission(array $permissionCodes): bool
    {
        return $this->role && $this->role->hasAnyPermission($permissionCodes);
    }

    /**
     * Check apakah user memiliki semua permission yang diberikan
     */
    public function hasAllPermissions(array $permissionCodes): bool
    {
        return $this->role && $this->role->hasAllPermissions($permissionCodes);
    }

    /**
     * Check apakah user memiliki role tertentu
     */
    public function hasRole(string $roleCode): bool
    {
        return $this->role && $this->role->code === $roleCode;
    }

    /**
     * Check apakah user adalah Super Admin
     */
    public function isSuperAdmin(): bool
    {
        return $this->hasRole('super_admin');
    }

    /**
     * Check apakah user adalah Kepala Gudang
     */
    public function isKepalaGudang(): bool
    {
        return $this->hasRole('kepala_gudang');
    }

    /**
     * Check apakah user adalah HR
     */
    public function isHR(): bool
    {
        return $this->hasRole('hr');
    }

    /**
     * Check apakah user adalah Pegawai
     */
    public function isPegawai(): bool
    {
        return $this->hasRole('pegawai');
    }

    /**
     * Check apakah user adalah Auditor
     */
    public function isAuditor(): bool
    {
        return $this->hasRole('audit');
    }

    /**
     * Check apakah user perlu memilih hub
     * Admin, HR, dan Audit harus pilih hub
     */
    public function needsHubSelection(): bool
    {
        return $this->isSuperAdmin() || $this->isHR() || $this->isAuditor();
    }

    /**
     * Check apakah user sudah memilih hub
     */
    public function hasSelectedHub(): bool
    {
        return !is_null($this->selected_hub_id) && !is_null($this->selected_city_id);
    }

    /**
     * Check apakah akun aktif
     */
    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    /**
     * Check apakah akun terkunci
     */
    public function isLocked(): bool
    {
        return $this->locked_until && $this->locked_until->isFuture();
    }

    /**
     * Increment percobaan login gagal
     */
    public function incrementLoginAttempts(): void
    {
        $this->increment('failed_login_attempts');

        // Batas percobaan login mengikuti konfigurasi keamanan (default 5).
        $maxAttempts = 5;
        try {
            $maxAttempts = (int) \App\Models\Setting::where('key', 'security.max_login_attempts')
                ->where('scope', 'global')
                ->where('scope_id', 0)
                ->value('value') ?: 5;
        } catch (\Throwable $e) {
            // Tabel settings belum tersedia: gunakan default.
        }

        if ($maxAttempts < 3) {
            $maxAttempts = 3;
        }

        if ($this->failed_login_attempts >= $maxAttempts) {
            // Durasi kunci mengikuti konfigurasi keamanan (default 15 menit).
            $lockoutMinutes = 15;
            try {
                $lockoutMinutes = (int) \App\Models\Setting::where('key', 'security.lockout_minutes')
                    ->where('scope', 'global')
                    ->where('scope_id', 0)
                    ->value('value') ?: 15;
            } catch (\Throwable $e) {
                // Tabel settings belum tersedia: gunakan default.
            }

            if ($lockoutMinutes < 5) {
                $lockoutMinutes = 5;
            }
            if ($lockoutMinutes > 120) {
                $lockoutMinutes = 120;
            }

            $this->locked_until = now()->addMinutes($lockoutMinutes);
            $this->save();
        }
    }

    /**
     * Reset percobaan login gagal
     */
    public function resetLoginAttempts(): void
    {
        $this->update([
            'failed_login_attempts' => 0,
            'locked_until' => null,
        ]);
    }

    /**
     * Update informasi login terakhir
     */
    public function updateLastLogin(string $ipAddress): void
    {
        $this->update([
            'last_login_at' => now(),
            'last_login_ip' => $ipAddress,
        ]);
    }

    /**
     * Scope: User aktif saja
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope: User dengan role tertentu
     */
    public function scopeWithRole($query, string $roleCode)
    {
        return $query->whereHas('role', function ($q) use ($roleCode) {
            $q->where('code', $roleCode);
        });
    }

    /**
     * Scope: User yang tidak terkunci
     */
    public function scopeNotLocked($query)
    {
        return $query->where(function ($q) {
            $q->whereNull('locked_until')
              ->orWhere('locked_until', '<=', now());
        });
    }

    /**
     * Accessor: Get nama role
     */
    public function getRoleNameAttribute(): ?string
    {
        return $this->role ? $this->role->name : null;
    }

    /**
     * Accessor: Get semua permission codes
     */
    public function getPermissionsAttribute(): array
    {
        if (!$this->role) {
            return [];
        }

        return $this->role->permissions->pluck('code')->toArray();
    }
}
