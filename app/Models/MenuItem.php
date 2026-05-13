<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\OrderItem;
use App\Models\Restaurant;

class MenuItem extends Model
{
    protected $fillable = [
        'restaurant_id',
        'name',
        'price',
        'preparation_time',
        'is_available',
        'image',
    ];

     protected $casts = [
        'price' => 'decimal:2',
        'is_available' => 'boolean',
    ];

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }
}
