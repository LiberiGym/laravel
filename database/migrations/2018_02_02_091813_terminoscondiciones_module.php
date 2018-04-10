<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TerminoscondicionesModule extends Migration
{

    public function up()
    {
        Schema::create('terminocondicion', function(Blueprint $table)
        {
            $table->increments('id');
            $table->string('title', 50)->default('');
            $table->longText('contenido');
            $table->string('status')->default('Activo');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('terminocondicion');
    }
}
