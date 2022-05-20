<?php

use Illuminate\Database\Seeder;

class ParameterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('parameters')->insert([
            'name' => 'simulatorState',
            'value' => '1',
        ]);
        DB::table('parameters')->insert([
            'name' => 'lastState',
            'value' => '1',
        ]);
        DB::table('parameters')->insert([
            'name' => 'roomSetting',
            'value' => '1',
        ]);
    }
}
