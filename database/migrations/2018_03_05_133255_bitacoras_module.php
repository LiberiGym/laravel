<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class BitacorasModule extends Migration
{

    public function up()
    {
        Schema::create('bitacora', function(Blueprint $table)
        {

            $table->increments('id');
            $table->date('fecha_solicitud');
            $table->date('fecha_autorizacion');
            $table->integer('sol_user_id')->unsigned()->default('0');
            $table->string('user_type', 50)->default('');
            $table->integer('aut_user_id')->unsigned()->default('0');
            $table->string('table', 245)->default('');
            $table->string('table_column', 245)->default('');
            $table->integer('table_id')->unsigned()->default('0');
            $table->longText('old_info');
            $table->longText('new_info');
            $table->longText('description');

            $table->string('status_auth')->default('En Revision');
            $table->string('status')->default('Activo');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bitacora');
    }
}
