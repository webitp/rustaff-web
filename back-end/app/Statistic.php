<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Statistic extends Model
{
    protected $table = 'players_statistic';

    protected $fillable = [
        'steamid', 'kills', 'deat', 'animal_kills', 
        'bradley_kills', 'heli_kills', 'sulfur', 'stones',
        'metall_ore', 'wood', 'time', 'updated_at'
    ];
}
