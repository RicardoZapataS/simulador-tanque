<?php

namespace App\Http\Controllers;

use App\Models\RoomSetting;
use Illuminate\Http\Request;

class RoomSettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\RoomSetting  $roomSetting
     * @return \Illuminate\Http\Response
     */
    public function show(RoomSetting $roomSetting)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\RoomSetting  $roomSetting
     * @return \Illuminate\Http\Response
     */
    public function edit(RoomSetting $roomSetting)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\RoomSetting  $roomSetting
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, RoomSetting $roomSetting)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\RoomSetting  $roomSetting
     * @return \Illuminate\Http\Response
     */
    public function destroy(RoomSetting $roomSetting)
    {
        //
    }

    public function GetRoomSetting(RoomSetting $roomSetting)
    {
        return $roomSetting;
    }
}
