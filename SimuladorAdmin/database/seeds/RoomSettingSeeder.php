<?php

use Illuminate\Database\Seeder;

class RoomSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('room_settings')->insert([
            'tankColor' => '#FF0000',
            'isRandomPosition' => '0',//false
            'tankSize' => '8',
            'ammountBullet' => '3',
            'targetDistance' => '1000.0',
            'TimeSimulator' => '00:00',
            'terrain_id' => '1',

        ]);
        DB::table('room_settings')->insert([
            'tankColor' => '#FFFF00',
            'isRandomPosition' => '1',//true
            'tankSize' => '6',
            'ammountBullet' => '1',
            'targetDistance' => '1300.0',
            'TimeSimulator' => '00:00',
            'terrain_id' => '2',

        ]);
        DB::table('room_settings')->insert([
            'tankColor' => '#FFFFFF',
            'isRandomPosition' => '1',//true
            'tankSize' => '4',
            'ammountBullet' => '1',
            'targetDistance' => '1500.0',
            'TimeSimulator' => '01:00',
            'terrain_id' => '3',

        ]);
    }
}
