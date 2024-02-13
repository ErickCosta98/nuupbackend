<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class likes extends Model
{
    use HasFactory;
    protected $fillable = [
        'weather_date_id',
        'ip_address',
        'liked_at'
    ];
    protected $casts = [
        'liked_at' => 'datetime'
    ];

    public function weather_dates()
    {
        return $this->belongsTo(weather_dates::class);
    }
    public function likesCount()
    {
        return $this->hasMany(weather_dates::class);
    }
}
