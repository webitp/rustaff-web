<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kits extends Model
{
    protected $fillable = [
        'name', 'cooldown', 'category'
    ];
}
