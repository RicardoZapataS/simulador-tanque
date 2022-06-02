<?php

namespace App\Http\Controllers;

use App\Models\RoomShooting;
use Illuminate\Http\Request;
use App\Models\Parameters;
use App\Models\RoomSetting;
use App\Models\DefaultSetting;
use App\Models\Room;
use App\User;

class MainController extends Controller
{
    public function index()
    {
        $defaultSettings = DefaultSetting::all();
        $tanquistas = User::all();
        return view("main.index", compact('defaultSettings', 'tanquistas'));
    }

    public function StartRoom(Request $request)
    {
        //dd($request->all());
        $this->setParameter(1, 2);
        $this->setParameter(2,2);
        // dd($request->ss_user_id);
        $roomSetting_id = -1;

        if($request->ss_room_setting != -1)
            $roomSetting_id = $request->ss_room_setting;
        else{
            $roomSetting = RoomSetting::create($request->all()+['isRandomPosition'=>$request->isRandomPositions ? 1 : 0]);
            $roomSetting_id = $roomSetting->id;
            // dd($roomSetting->id);
        }
        $room = new Room();
        $room->room_setting_id = $roomSetting_id;
        $room->user_id = $request->ss_user_id;
        $room->save();

        $this->setParameter(3, $room->id);

        // dd($roomSetting);
        return redirect(route('simulator'));
    }
    public function SimulatorScreem(Request $request)
    {
        $room = Room::find($this->getParameter(3));
        $room_setting = RoomSetting::find($room->room_setting_id);
        $room_shootings = $room->room_shootings;
        //dd($room_shootings[0]->tar);
        $defaultSettings = DefaultSetting::where('room_setting_id', $room->room_setting_id)->get()->first()? DefaultSetting::where('room_setting_id', $room->room_setting_id)->get()->first()->name : "Personalizado";
        // dd($defaultSettings);
        $user = User::find($room->user_id);
        return view('main.simulatorScreem', compact('room', 'room_setting', 'user', 'defaultSettings', 'room_shootings'));
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
