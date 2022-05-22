<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Ricardo Zapata',
            'email' => 'ricardolociorz@gmail.com',//true
            'password' => Hash::make("Wasori2020"),
        ]);
    }
}
