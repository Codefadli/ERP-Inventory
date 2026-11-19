<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode',
        'nama',
        'deskripsi',
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
        return $this->hasMany(Item::class, 'category_id');
    }
}
