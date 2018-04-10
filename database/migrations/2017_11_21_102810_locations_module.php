<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class LocationsModule extends Migration
{

    public function up()
    {
        Schema::create('location', function(Blueprint $table)
        {
            $table->increments('id');
            $table->string('title', 50);
            $table->integer('state_id')->unsigned();
            $table->foreign('state_id')->references('id')->on('state');
            $table->string('status')->default('Activo');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('location');
    }
}
