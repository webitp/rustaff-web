<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Items extends Model
{
    protected $fillable = [
        'category', 'name', 'game_name', 'price', 'count', 'image', 'type'
    ];
}
