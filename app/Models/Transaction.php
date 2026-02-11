<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'user_id',
        'parking_area_id',
        'vehicle_id',
        'date_in',
        'date_out',
        'minutes_duration',
        'amount',
    ];

    public $timestamps = true;

    public $incrementing = true;

    protected $hidden = [];

    protected $appends = [];
}
