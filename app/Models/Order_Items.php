<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order_Items extends Model
{
    protected $fillable = [
        'order_id',
        'menu_item_id',
        'quantity',
        'price',
    ];
}
