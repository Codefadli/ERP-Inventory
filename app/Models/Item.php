<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Item extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'sku',
        'barcode',
        'nama',
        'category_id',
        'unit_id',
        'location_id',
        'supplier_id',
        'division_id',
        'stok_minimum',
        'harga_beli',
        'harga_jual',
        'deskripsi',
        'foto',
        'status',
    ];

    protected $casts = [
        'category_id' => 'integer',
        'unit_id' => 'integer',
        'location_id' => 'integer',
        'supplier_id' => 'integer',
        'division_id' => 'integer',
        'stok_minimum' => 'integer',
        'harga_beli' => 'decimal:2',
        'harga_jual' => 'decimal:2',
        'status' => 'boolean',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function division()
    {
        return $this->belongsTo(Division::class);
    }
}
