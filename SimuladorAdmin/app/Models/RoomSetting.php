<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoomSetting extends Model
{
    protected $fillable = [
        'tankColor',
        'isRandomPosition',
        'tankSize',
        'ammountBullet',
        'targetDistance',
        'TimeSimulator'
    ];
}
