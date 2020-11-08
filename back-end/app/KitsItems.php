<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class KitsItems extends Model
{
    protected $table = 'kits_items';

    protected $fillable = [
        'kit', 'game_name', 'count'
    ];
}
