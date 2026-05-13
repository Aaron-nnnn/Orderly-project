<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Restaurant;
use App\Models\Order;

class RestaurantTable extends Model
{
    
      protected $fillable = [
        'restaurant_id',
        'table_number',
        'total_seats',
        'status',
        'occupied_until',
    ];

     protected $casts = [
        'occupied_until' => 'datetime',
    ];

     public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'table_id');
    }
}
