<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RestaurantTables extends Model
{
    
      protected $fillable = [
        'restaurant_id',
        'table_number',
        'total_seats',
        'status',
        'occupied_until',
    ];
}
