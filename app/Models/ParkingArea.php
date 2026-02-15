<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ParkingArea extends Model
{
    protected $fillable = [
        'rate_id',
        'name',
        'capacity',
        'type'
    ];

    public $timestamps = true;

    public $incrementing = true;

    protected $hidden = [];

    protected $appends = [
        'typeAt'
    ];

    public function rate()
    {
        return $this->belongsTo(Rates::class, 'rate_id', 'id');
    }

    public function getTypeAtAttribute()
    {
        try {
            $arr = [
                'private' => 'Area Parkir Privat',
                'public' => 'Area Parkir Publik',
            ];

            return isset($arr[$this->type]) ? $arr[$this->type] : $this->type;
        } catch (\Exception $e) {
            return null;
        }
    }
}
