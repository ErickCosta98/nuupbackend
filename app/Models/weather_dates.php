<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class weather_dates extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'lat',
        'lon'
    ];
    protected $casts = [
        'date' => 'date'
    ];
    public function weather_dates()
    {
        return $this->hasMany(likes::class);
    }
    public function likes()
    {
        return $this->hasMany(likes::class);
    }

    public function likesCount()
    {
        return $this->hasMany(likes::class);
    }
}
