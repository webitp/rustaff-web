<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RulletItems extends Model
{
    protected $fillable = [
        'name', 'is_constant', 'type', 'image'
    ];
}
