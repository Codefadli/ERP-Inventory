<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Outbound extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode',
        'permintaan',
        'item_id',
        'departemen',
        'pic',
        'qty',
        'satuan',
        'tujuan',
        'status',
        'user_id',
        'hub_id',
        'keterangan',
    ];

    protected $casts = [
        'qty' => 'integer',
    ];

    public function item()
    {
        return $this->belongsTo(Item::class, 'item_id');
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
