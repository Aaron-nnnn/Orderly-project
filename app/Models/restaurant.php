<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class restaurant extends Model
{
    
      protected $fillable = [
        'name',
        'location',
        'total_tables',
        'seating_layout',
    ];
}
