<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payments extends Model
{
      protected $fillable = [
        'order_id',
        'amount',
        'type',
        'status',
        'method',
    ];
}
