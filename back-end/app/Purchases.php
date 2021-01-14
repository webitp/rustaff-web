<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Purchases extends Model
{
    protected $fillable = [
        'steamid', 'item', 'used', 'count', 'type', 'hidden', 'created_at'
    ];
}