<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MenuItems extends Model
{
    protected $fillable = [
        'restaurant_id',
        'name',
        'price',
        'preparation_time',
        'is_available',
    ];
}
