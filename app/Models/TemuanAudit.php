<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TemuanAudit extends Model
{
    use HasFactory;

    protected $table = 'temuan_audits';

    protected $fillable = [
        'kode',
        'judul',
        'deskripsi',
        'tingkat',
        'status',
        'lokasi',
        'user_id',
        'hub_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function hub()
    {
        return $this->belongsTo(Hub::class, 'hub_id');
    }
}
