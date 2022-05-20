<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Parameters;
use App\Models\RoomSetting;
use App\Models\DefaultSetting;

class MainController extends Controller
{
    public function index()
    {
        $defaultSettings = DefaultSetting::all();
        return view("main.index", compact('defaultSettings'));
    }

    public function StartRoom (Request $request)
    {
        $simulatorState = Parameters::find(1);
        $simulatorState->value = 2;
        $simulatorState->save();
        $lastState = Parameters::find(2);
        $lastState->value = 2;
        $lastState->save();
        //dd($request->isRandomPosition);

        $roomSetting = RoomSetting::create($request->all()+['isRandomPosition'=>$request->isRandomPositions ? 1 : 0]);
        dd($roomSetting);
        return redirect(route('index'));
    }
}
