<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsTableTerminocondicion extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('terminocondicion', function (Blueprint $table) {
            //
            $table->longText('terminos_web_inicio');
            $table->longText('terminos_web_bancarios');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('terminocondicion', function (Blueprint $table) {
            //
        });
    }
}
