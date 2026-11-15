<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hub extends Model
{
    use HasFactory;

    protected $fillable = [
        'city_id',
        'code',
        'name',
        'category',
        'address',
        'capacity',
        'occupancy',
        'area',
        'status',
    ];

    /**
     * Relasi: Hub belongs to City
     */
    public function city()
    {
        return $this->belongsTo(City::class);
    }

    /**
     * Relasi: Hub memiliki banyak Users yang memilih hub ini
     */
    public function users()
    {
        return $this->hasMany(User::class, 'selected_hub_id');
    }

    /**
     * Scope: Hub yang aktif
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope: Hub di city tertentu
     */
    public function scopeInCity($query, $cityId)
    {
        return $query->where('city_id', $cityId);
    }
}
