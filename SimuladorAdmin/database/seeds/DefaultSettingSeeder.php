<?php

use Illuminate\Database\Seeder;

class DefaultSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('default_settings')->insert([
            'name' => 'Basico',
            'room_setting_id' => '1',
        ]);
        DB::table('default_settings')->insert([
            'name' => 'Medio',
            'room_setting_id' => '2',
        ]);
        DB::table('default_settings')->insert([
            'name' => 'Moderado',
            'room_setting_id' => '3',
        ]);
    }
}
