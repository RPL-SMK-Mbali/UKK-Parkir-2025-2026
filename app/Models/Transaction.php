<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'name',
        'message',
        'icon',
        'color',
        'action_url',
        'is_read',
        'is_system',
        'category',
    ];

    public $timestamps = true;

    public $incrementing = true;

    protected $hidden = [];

    protected $appends = [];
}
