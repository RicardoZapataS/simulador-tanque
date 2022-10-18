<?php

use Illuminate\Database\Seeder;

class TerrainSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('terrains')->insert([
            'name' => 'Terreno 1',
            'value' => 'Scene 1'
        ]);
        DB::table('terrains')->insert([
            'name' => 'Terreno 2',
            'value' => 'Scene 2'
        ]);
        DB::table('terrains')->insert([
            'name' => 'Terreno 3',
            'value' => 'Scene 3'
        ]);
    }
}
