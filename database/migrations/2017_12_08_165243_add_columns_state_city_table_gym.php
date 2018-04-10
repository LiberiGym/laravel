<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsStateCityTableGym extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('gym', function (Blueprint $table) {
            $table->integer('state_id')->unsigned()->after('gym_state');
            $table->integer('location_id')->unsigned()->after('gym_city');

            $table->foreign('state_id')->references('id')->on('state');
            $table->foreign('location_id')->references('id')->on('location');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('gym', function (Blueprint $table) {
            //
        });
    }
}
