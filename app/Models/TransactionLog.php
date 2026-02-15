<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransactionLog extends Model
{
    protected $fillable = [
        'user_id',
        'transaction_id',
        'activities',
    ];

    public $timestamps = true;

    public $incrementing = true;

    protected $hidden = [];

    protected $appends = [];
}
