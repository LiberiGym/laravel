<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateModulesUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_cards', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->string('owner', 50)->default('');
            $table->string('number', 19)->default('');
            $table->string('mm', 2)->default('');
            $table->string('aa', 2)->default('');
            $table->string('cvv', 4)->default('');
            $table->string('prefer', 1)->default('0');
            $table->string('status')->default('Activo');

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_id')->references('id')->on('users');
        });

        Schema::create('users_cards_inuse', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->integer('cards_id')->unsigned();
            $table->integer('related_cards_id')->unsigned();
            $table->string('authorize', 1)->default('0');
            $table->string('status')->default('Activo');

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('cards_id')->references('id')->on('users_cards');
        });

        Schema::create('users_preferences', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->string('distance', 2)->default('2');
            $table->decimal('price', 10,2)->default('500.00');

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_id')->references('id')->on('users');
        });

        Schema::create('users_categories', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->integer('category_id')->unsigned();

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('category_id')->references('id')->on('category');
        });

        Schema::create('users_notifications', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->integer('users_cards_inuse_id')->unsigned()->default('0');
            $table->datetime('notification_date');
            $table->string('title', 200)->default('');
            $table->string('message', 500)->default('');
            $table->string('type', 1)->default('1');// 1=aviso, 2=confirmacion
            $table->string('action', 500)->default('');// metodo de la accion
            $table->string('iagree', 1)->default('0');// 1/0
            $table->string('viewed', 1)->default('0');// 1/0
            $table->string('status')->default('Activo');

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_id')->references('id')->on('users');
        });

        Schema::create('users_purchases', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->integer('gym_id')->unsigned();
            $table->integer('users_cards_id')->unsigned();
            $table->datetime('fecha');
            $table->decimal('amount', 10,2)->default('0.00');
            $table->string('used', 1)->default('0');
            $table->datetime('dateuse')->nullable();
            $table->datetime('validity')->nullable();
            $table->string('locked', 1)->default('0');
            $table->string('qualified', 1)->default('0')->comment('0=no calificado, 1=calificado, 2=omitido'); //0=no calificado, 1=calificado, 2=omitido
            $table->string('status')->default('Activo');

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('gym_id')->references('id')->on('gym');
            $table->foreign('users_cards_id')->references('id')->on('users_cards');
        });

        Schema::create('users_qualification', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('users_purchases_id')->unsigned();
            $table->datetime('fecha');
            $table->string('calificacion', 2)->default('0');
            $table->string('comment',500)->default('');
            $table->string('status')->default('Activo');

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('users_purchases_id')->references('id')->on('users_purchases');
        });

        Schema::create('users_freevisits', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->integer('users_purchases_id')->unsigned();
            $table->datetime('fecha');
            $table->string('type')->default('')->comment('1=cortesia, 2=6 visitas');
            $table->string('status')->default('Activo');

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('users_purchases_id')->references('id')->on('users_purchases');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::dropIfExists('users_freevisits');
        Schema::dropIfExists('users_qualification');
        Schema::dropIfExists('users_purchases');
        Schema::dropIfExists('users_notifications');
        Schema::dropIfExists('users_categories');
        Schema::dropIfExists('users_preferences');
        Schema::dropIfExists('users_cards_inuse');
        Schema::dropIfExists('users_cards');
    }
}
