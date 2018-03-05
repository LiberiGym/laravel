<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PromocionesModule extends Migration
{

    public function up()
    {
        Schema::create('promocion', function(Blueprint $table)
        {
            $table->increments('id');
            $table->string('nombre_promocion', 245);
            $table->date('vigencia');
            $table->string('tipo', 1)->default('1');//1=especie/2=porcentaje
            $table->decimal('monto', 2,0);
            $table->string('limite', 1)->default('0');//0=sin limite/1=con limite
            $table->decimal('cantidad', 2,0);
            $table->string('por_usuario', 1)->default('0');//0=general/1=por usuario

            $table->string('status')->default('Activo');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('promocion');
    }
}
