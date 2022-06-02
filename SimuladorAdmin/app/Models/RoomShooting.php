<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoomShooting extends Model
{
    protected $fillable = ['time', 'site_shooting', 'target', 'room_id'];

    public function getTagAttribute()
    {
        switch ($this->site_shooting) {
            case "0":
                return asset('assets/img/targets/oruga.png');
            case "1":
                return asset('assets/img/targets/canon.png');
            case "2":
                return asset('assets/img/targets/batea.png');
            case "3":
                return asset('assets/img/targets/cabina.png');
        }
    }
    public function getTagNameAttribute()
    {
        switch ($this->site_shooting) {
            case "0":
                return "Oruga";
            case "1":
                return "Cañon";
            case "2":
                return "Batea";
            case "3":
                return "Cabina";
        }
    }

    public function getTarAttribute()
    {
        switch ($this->target) {
            case "0":
                return "Primer objetivo";
            case "1":
                return "Segundo objetivo";
            case "2":
                return "Tercer objetivo";
        }
    }
}
