<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockOpname extends Model
{
    use HasFactory;

    protected $table = 'stock_opnames';

    protected $fillable = [
        'item_id',
        'user_id',
        'hub_id',
        'qty_sistem',
        'qty_fisik',
        'selisih',
        'status',
        'catatan',
    ];

    protected $casts = [
        'qty_sistem' => 'integer',
        'qty_fisik' => 'integer',
        'selisih' => 'integer',
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
