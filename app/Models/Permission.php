<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'group',
        'description',
    ];

    /**
     * Relasi: Permission dimiliki oleh banyak Role (many-to-many)
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_permissions')
            ->withTimestamps();
    }

    /**
     * Scope: Filter berdasarkan group
     */
    public function scopeByGroup($query, string $group)
    {
        return $query->where('group', $group);
    }

    /**
     * Get semua permission yang dikelompokkan berdasarkan group
     */
    public static function getAllGrouped()
    {
        return static::orderBy('group')->orderBy('name')->get()->groupBy('group');
    }
}
