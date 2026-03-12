<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
     protected $fillable = [
        'user_id',
        'restaurant_id',
        'table_id',
        'total_amount',
        'deposit_amount',
        'balance_amount',
        'estimated_ready_time',
        'status',
    ];
}
