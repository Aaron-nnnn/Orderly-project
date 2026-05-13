<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Restaurant;
use App\Models\RestaurantTable;
use App\Models\OrderItem;

class Order extends Model
{
    protected $table = 'orders';

    protected $fillable = [
        'user_id',
        'restaurant_id',
        'table_id',
        'order_type',
        'total_amount',
        'status',
        'payment_method',
        'amount_paid',
        'is_paid'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }

    public function restaurantTable()
    {
        return $this->belongsTo(RestaurantTable::class, 'table_id');
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}