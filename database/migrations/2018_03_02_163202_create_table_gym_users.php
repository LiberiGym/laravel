<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableGymUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gym_users', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('gym_id')->unsigned();
            $table->integer('user_id')->unsigned();

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('gym_id')->references('id')->on('gym');
            $table->foreign('user_id')->references('id')->on('users');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('gym_users');
    }
}
