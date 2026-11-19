<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestBarang extends Model
{
    use HasFactory;

    protected $table = 'requests';

    protected $fillable = [
        'tiket',
        'tipe',
        'rincian',
        'prioritas',
        'approver',
        'status',
        'user_id',
        'hub_id',
        'disetujui_at',
    ];

    protected $casts = [
        'disetujui_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function hub()
    {
        return $this->belongsTo(Hub::class, 'hub_id');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'Menunggu');
    }
}
