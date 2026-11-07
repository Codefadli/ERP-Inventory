<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'region',
        'status',
        'active_hubs_count',
        'areas',
    ];

    protected $casts = [
        'areas' => 'array',
    ];

    /**
     * Relasi: City memiliki banyak Hubs
     */
    public function hubs()
    {
        return $this->hasMany(Hub::class);
    }

    /**
     * Relasi: City memiliki banyak Users yang memilih city ini
     */
    public function users()
    {
        return $this->hasMany(User::class, 'selected_city_id');
    }

    /**
     * Scope: City yang aktif
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Get hubs yang aktif di city ini
     */
    public function getActiveHubsAttribute()
    {
        return $this->hubs()->where('status', 'active')->get();
    }
}
