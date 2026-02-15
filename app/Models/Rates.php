<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rates extends Model
{
    protected $fillable = [
        'name',
        'hourly_rate',
    ];

    public $timestamps = true;

    public $incrementing = true;

    protected $hidden = [];

    protected $appends = [
        'hourlyRateAt'
    ];

    public function getHourlyRateAtAttribute()
    {
        return number_format($this->hourly_rate, 0, ',', '.');
    }
}
