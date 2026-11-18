<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;

class Setting extends Model
{
    use HasFactory;

    public const SCOPE_GLOBAL = 'global';
    public const SCOPE_HUB = 'hub';
    public const SCOPE_USER = 'user';

    protected $fillable = [
        'key',
        'value',
        'type',
        'scope',
        'scope_id',
        'is_encrypted',
        'updated_by',
    ];

    protected $casts = [
        'scope_id' => 'integer',
        'is_encrypted' => 'boolean',
    ];

    /**
     * Nilai mentah terenkripsi tidak boleh ikut terserialisasi ke frontend.
     */
    protected $hidden = [
        'value',
    ];

    /**
     * Accessor: dekripsi nilai jika ditandai sebagai rahasia.
     * Jika dekripsi gagal (mis. APP_KEY berubah), kembalikan null agar
     * aplikasi tidak error dan administrator dapat mengisi ulang.
     */
    public function getDecryptedValueAttribute(): ?string
    {
        if ($this->value === null) {
            return null;
        }

        if (!$this->is_encrypted) {
            return $this->value;
        }

        try {
            return Crypt::decryptString($this->value);
        } catch (\Throwable $e) {
            return null;
        }
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function scopeForScope($query, string $scope, int $scopeId = 0)
    {
        return $query->where('scope', $scope)->where('scope_id', $scopeId);
    }
}
