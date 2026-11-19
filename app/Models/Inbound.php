<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inbound extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode',
        'surat_jalan',
        'supplier_id',
        'item_id',
        'qty',
        'satuan',
        'location_id',
        'dock',
        'status',
        'user_id',
        'hub_id',
        'keterangan',
    ];

    protected $casts = [
        'qty' => 'integer',
    ];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }

    public function item()
    {
        return $this->belongsTo(Item::class, 'item_id');
    }

    public function location()
    {
        return $this->belongsTo(Location::class, 'location_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function hub()
    {
        return $this->belongsTo(Hub::class, 'hub_id');
    }
}
