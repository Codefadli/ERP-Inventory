<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'description',
        'is_system',
        'status',
    ];

    protected $casts = [
        'is_system' => 'boolean',
        'status' => 'boolean',
    ];

    /**
     * Relasi: Role memiliki banyak User
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }

    /**
     * Relasi: Role memiliki banyak Permission (many-to-many)
     */
    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'role_permissions')
            ->withTimestamps();
    }

    /**
     * Check apakah role memiliki permission tertentu
     */
    public function hasPermission(string $permissionCode): bool
    {
        return $this->permissions()->where('code', $permissionCode)->exists();
    }

    /**
     * Check apakah role memiliki salah satu dari permission yang diberikan
     */
    public function hasAnyPermission(array $permissionCodes): bool
    {
        return $this->permissions()->whereIn('code', $permissionCodes)->exists();
    }

    /**
     * Check apakah role memiliki semua permission yang diberikan
     */
    public function hasAllPermissions(array $permissionCodes): bool
    {
        $count = $this->permissions()->whereIn('code', $permissionCodes)->count();
        return $count === count($permissionCodes);
    }

    /**
     * Scope: Role aktif saja
     */
    public function scopeActive($query)
    {
        return $query->where('status', true);
    }

    /**
     * Scope: Role non-sistem (yang dapat diubah/dihapus)
     */
    public function scopeNonSystem($query)
    {
        return $query->where('is_system', false);
    }
}
