<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\RoomSetting;
use App\Models\RoomShooting;
use App\User;
use Illuminate\Http\Request;

class PointController extends Controller
{
    public  function index(){
        $rooms = Room::all();
        return view('historial.index', compact('rooms'));
    }
    public  function show($id){
        $room = Room::find($id);
        $room_shootings = RoomShooting::where('room_id', $id)->get();
        $point = $this->grafico($room_shootings);
        $point['name'] = $room->room_setting_id == 1 ? 'Basico' : ($room->room_setting_id == 2 ? 'Medio' : ($room->room_setting_id == 3 ? 'Avanzado' : ('P'.date('d-m-Y', strtotime($room->created_at)))));
        $room_setting = RoomSetting::find($room->room_setting_id);

        return view('historial.show', compact('room', 'room_setting', 'point',  'room_shootings'));
    }
    public function grafico($room_shootings){
        $point = array(
            'precision' => 0,
            'cabina' => 0,
            'batea' => 0,
            'cañon' => 0,
            'oruga' => 0,
            'reaccion' => 0,
            'name' => 'Personalizado',
            'room' => new Room()
        );
        foreach ($room_shootings as $room_shooting){

            $point["precision"] = $point["precision"] + (($room_shooting->site_shooting != -1) ? 1 : 0);
            $point["oruga"] = $point["oruga"] + (($room_shooting->site_shooting == 0) ? 1 : 0);
            $point["cañon"] = $point["cañon"] + (($room_shooting->site_shooting == 1) ? 1 : 0);
            $point["batea"] = $point["batea"] + (($room_shooting->site_shooting == 2) ? 1 : 0);
            $point["cabina"] = $point["cabina"] + (($room_shooting->site_shooting == 3) ? 1 : 0);
            $point["reaccion"] = $point["reaccion"] + $room_shooting->time;
        }
        $point["precision"] = ($point["precision"] / $room_shootings->count())*100;
        $point["oruga"] = ($point["oruga"] / $room_shootings->count())*100;
        $point["batea"] = ($point["batea"] / $room_shootings->count())*100;
        $point["cabina"] = ($point["cabina"] / $room_shootings->count())*100;
        $point["cañon"] = ($point["cañon"] / $room_shootings->count())*100;
        $point["reaccion"] = $point["reaccion"] / $room_shootings->count();

        return $point;
    }
    public function personal($user){
        $rooms = Room::where('user_id', $user)->get();
        $points = array();
        foreach ($rooms as $key=> $room){
            $room_shootings = RoomShooting::where('room_id', $room->id)->get();
            $point = $this->grafico($room_shootings);
            $point['name'] = $room->room_setting_id == 1 ? 'Basico' : ($room->room_setting_id == 2 ? 'Medio' : ($room->room_setting_id == 3 ? 'Avanzado' : ('P'.date('d-m-Y', strtotime($room->created_at)))));
            $point['room'] = $room;
            array_push($points, $point);
        }
        //dd($point, $room_shootings);
        return view('historial.personal', compact('rooms', 'points'));
    }
    public function print($user){
        $rooms = Room::where('user_id', $user)->get();
        $room = $rooms[0];
        $points = array();
            $room_shootings = RoomShooting::where('room_id', $room->id)->get();
            $point = $this->grafico($room_shootings);
            $point['name'] = $room->room_setting_id == 1 ? 'Basico' : ($room->room_setting_id == 2 ? 'Medio' : ($room->room_setting_id == 3 ? 'Avanzado' : ('P'.date('d-m-Y', strtotime($room->created_at)))));
            $point['room'] = $room;
            array_push($points, $point);
        $data = [
            'rooms' => $rooms,
            'points' => $points
        ];
        return \PDF::loadView('pdf.personal_pdf', $data)
            ->stream('historial.pdf');
    }

    public function general(){
        $users = User::where('password', '=', 'unpassword')->get();
        $notas = array();
        foreach ($users as $user){
            $nota = array(
                'nombre' => $user->name . $user->lastname,
                'n_basico' => 0,
                'n_medio' => 0,
                'n_avanzado' => 0,
                'n_promedio' => 0,
            );
            $rooms_basico = Room::where('user_id', $user->id)->where('room_setting_id', 1)->get()->first();
            //dd($rooms_basico);
            if (!is_null($rooms_basico)){
                //dd($rooms_basico);

                $room_shootings_b = RoomShooting::where('room_id', $rooms_basico->id)->get();

                $nota['n_basico'] = $this->calificar($room_shootings_b);

                $rooms_medio = Room::where('user_id', $user->id)->where('room_setting_id', 2)->get()->first();
                if (!is_null($rooms_medio)){
                    $room_shootings_m = RoomShooting::where('room_id', $rooms_basico->id)->get();

                    $nota['n_medio'] = $this->calificar($room_shootings_m);

                    $rooms_avanzado = Room::where('user_id', $user->id)->where('room_setting_id', 3)->get()->first();
                    if (!is_null($rooms_avanzado)){
                        $room_shootings_a = RoomShooting::where('room_id', $rooms_basico->id)->get();

                        $nota['n_avanzado'] = $this->calificar($room_shootings_a);

                        $nota['n_promedio'] = round(($nota['n_basico'] + $nota['n_medio'] + $nota['n_avanzado']) / 3, 2);
                    }else{
                        $nota['n_avanzado'] = 0;
                        $nota['n_promedio'] = round(($nota['n_basico'] + $nota['n_medio']) / 3, 2);
                    }
                }else{
                    $nota['n_medio'] = 0;
                    $nota['n_avanzado'] = 0;
                    $nota['n_promedio'] = round($nota['n_basico'] / 3, 2);
                }
            }else{
                $nota['n_basico'] = 0;
                $nota['n_medio'] = 0;
                $nota['n_avanzado'] = 0;
                $nota['n_promedio'] = 0;
            }

            array_push($notas, $nota);


        }
        //dd($users);
        return view('historial.general', compact('notas'));
    }
    public function calificar($room_shootings){
        $point = array(
            'cabina' => 0,
            'batea' => 0,
            'cañon' => 0,
            'oruga' => 0,
        );
        foreach ($room_shootings as $room_shooting){
            $point["oruga"] = $point["oruga"] + (($room_shooting->site_shooting == 0) ? 1 : 0);
            $point["cañon"] = $point["cañon"] + (($room_shooting->site_shooting == 1) ? 1 : 0);
            $point["batea"] = $point["batea"] + (($room_shooting->site_shooting == 2) ? 1 : 0);
            $point["cabina"] = $point["cabina"] + (($room_shooting->site_shooting == 3) ? 1 : 0);
        }
        $nota = (($point["oruga"] * 100) + ($point["cañon"] * 80) + ($point["batea"] *70) + ($point["cabina"] * 100)) / (($point["oruga"]) + ($point["cañon"]) + ($point["batea"]) + ($point["cabina"]));
//        dd($nota, $point, $room_shooting->count());
        return round($nota,  2);
    }
}
