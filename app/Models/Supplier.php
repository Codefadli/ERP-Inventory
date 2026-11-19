<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Supplier extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'kode',
        'nama',
        'pic',
        'telepon',
        'email',
        'kota',
        'alamat',
        'hub_id',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    public function hub()
    {
        return $this->belongsTo(Hub::class, 'hub_id');
    }

    public function items(): HasMany
    {
        return $this->hasMany(Item::class, 'supplier_id');
    }
}
