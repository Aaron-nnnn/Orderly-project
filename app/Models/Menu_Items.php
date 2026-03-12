<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu_Items extends Model
{
    protected $fillable = [
        'restaurant_id',
        'name',
        'price',
        'preparation_time',
        'is_available',
    ];
}
