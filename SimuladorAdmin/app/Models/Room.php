<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $fillable = ['room_setting_id', 'user_id'];

    public function room_shootings(){
        return $this->hasMany(RoomShooting::class);
    }
    public  function user(){
        return $this->belongsTo(User::class);
    }
    public  function room_setting(){
        return $this->belongsTo(RoomSetting::class);
    }
}
