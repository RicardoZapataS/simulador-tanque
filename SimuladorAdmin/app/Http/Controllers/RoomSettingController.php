<?php

namespace App\Http\Controllers;

use App\Models\RoomSetting;
use App\Models\Room;
use App\Models\RoomShooting;
use Illuminate\Http\Request;
use App\Models\Parameters;

class RoomSettingController extends Controller
{


    public function GetRoomSettings()
    {
        $room = Room::find($this->getParameter(3));
        $room_setting = RoomSetting::find($room->room_setting_id);
        return $room_setting;
    }
    public function GetRoomSetting(RoomSetting $roomSetting)
    {
        return $roomSetting;
    }

    public function GetSimulatorState()
    {
        $state = Parameters::find(1);
        return $state;
    }
    public function SetState($value)
    {
        $state = Parameters::find(1);
        $state->value = $value;
        $state->save();
        return $state;
    }
    public function ShootingTarget($time, $site_shooting, $target)
    {
        $room = Room::find($this->getParameter(3));
        $room_shooting = new RoomShooting();
        $room_shooting->time = $time;
        $room_shooting->site_shooting = $site_shooting;
        $room_shooting->target = $target;
        $room_shooting->room_id = $room->id;
        $room_shooting->save();
    }
    public function GetShootingTarget()
    {
        $room_shootings = Room::find($this->getParameter(3))->room_shootings;
        return $room_shootings;
    }
    private function setParameter($id, $value)
    {
        $simulatorState = Parameters::find($id);
        $simulatorState->value = $value;
        $simulatorState->save();
    }
    private function getParameter($id)
    {
        $simulatorState = Parameters::find($id);
        return $simulatorState->value;
    }
}
