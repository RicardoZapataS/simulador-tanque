<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoomSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('room_settings', function (Blueprint $table) {
            $table->id();
            $table->string("tankColor");
            $table->boolean("isRandomPosition");
            $table->float("tankSize");
            $table->integer("ammountBullet");
            $table->float("targetDistance");
            $table->string("TimeSimulator");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('room_settings');
    }
}
