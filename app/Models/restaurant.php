<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Order;
use App\Models\MenuItem;
use App\Models\RestaurantTable;

class Restaurant extends Model
{
    
      protected $fillable = [
        'user_id',
        'name',
        'location',
        'total_tables',
        'seating_layout',
    ];

     public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function menuItems()
    {
        return $this->hasMany(MenuItem::class);
    }

    public function tables()
    {
        return $this->hasMany(RestaurantTable::class);
    }
}
