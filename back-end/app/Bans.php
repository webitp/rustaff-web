<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bans extends Model
{
    protected $table = 'ban_list';

    protected $fillable = [
        'steamid', 'name', 'reason'
    ];
}
