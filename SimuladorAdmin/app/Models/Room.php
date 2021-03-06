<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $fillable = ['room_setting_id', 'user_id'];

    public function room_shootings(){
        return $this->hasMany(RoomShooting::class);
    }
}
