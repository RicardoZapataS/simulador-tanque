<?php

namespace App\Http\Controllers;

use App\Models\RoomSetting;
use App\Models\Room;
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
    public function SetLowState()
    {
        $state = Parameters::find(1);
        $state->value = 1;
        $state->save();
        return $state;
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
