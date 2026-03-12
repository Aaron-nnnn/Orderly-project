<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Restaurant_Tables extends Model
{
    
      protected $fillable = [
        'restaurant_id',
        'table_number',
        'total_seats',
        'status',
        'occupied_until',
    ];
}
