<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserToken extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'type',
        'token_hash',
        'expires_at',
        'used_at',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'used_at' => 'datetime',
    ];

    /**
     * Relasi: Token dimiliki oleh User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Check apakah token sudah digunakan
     */
    public function isUsed(): bool
    {
        return !is_null($this->used_at);
    }

    /**
     * Check apakah token sudah kedaluwarsa
     */
    public function isExpired(): bool
    {
        return $this->expires_at->isPast();
    }

    /**
     * Check apakah token masih valid (belum digunakan dan belum kedaluwarsa)
     */
    public function isValid(): bool
    {
        return !$this->isUsed() && !$this->isExpired();
    }

    /**
     * Tandai token sebagai sudah digunakan
     */
    public function markAsUsed(): bool
    {
        $this->used_at = now();
        return $this->save();
    }

    /**
     * Scope: Token yang belum kedaluwarsa
     */
    public function scopeNotExpired($query)
    {
        return $query->where('expires_at', '>', now());
    }

    /**
     * Scope: Token yang belum digunakan
     */
    public function scopeNotUsed($query)
    {
        return $query->whereNull('used_at');
    }

    /**
     * Scope: Token yang masih valid
     */
    public function scopeValid($query)
    {
        return $query->notExpired()->notUsed();
    }
}
