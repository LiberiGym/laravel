<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class GymsModule extends Migration
{

    public function up()
    {
        Schema::create('gym', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->string('tradename', 245)->default('');
            $table->string('manager', 245)->default('');
            $table->string('manager_cel', 15)->default('');

            $table->decimal('gym_monthly_fee', 10,2)->default(0);
            $table->string('gym_schedule', 245)->default('');
            $table->string('gym_phone', 15)->default('');
            $table->string('gym_email', 50)->default('');
            $table->string('gym_web', 245)->default('');
            $table->string('gym_street', 150)->default('');
            $table->string('gym_number', 20)->default('');
            $table->string('gym_neighborhood', 150)->default('');
            $table->string('gym_zipcode', 10)->default('');
            $table->string('gym_state', 150)->default('');
            $table->string('gym_city', 150)->default('');
            $table->longText('gym_description');
            $table->string('gym_logo', 50)->default('default.png');
            $table->string('gym_register', 50)->default('');
            $table->string('gym_url_video', 245)->default('');
            $table->string('gym_logo_change', 1)->default(1);

            $table->string('razon_social', 245)->default('');
            $table->string('rfc', 15)->default('');
            $table->string('calle', 150)->default('');
            $table->string('no_ext', 20)->default('');
            $table->string('no_int', 20)->default('');
            $table->string('colonia', 150)->default('');
            $table->string('cp', 10)->default('');
            $table->string('ciudad', 150)->default('');
            $table->string('municipio', 150)->default('');
            $table->string('estado', 150)->default('');
            $table->string('pais', 100)->default('');
            $table->string('cta_titular', 245)->default('');
            $table->string('cta_numero', 50)->default('');
            $table->string('cta_clabe', 50)->default('');
            $table->string('cta_banco', 50)->default('');
            $table->string('cta_pais', 100)->default('');
            $table->string('terminos_condiciones', 1)->default(1);

            $table->datetime('publish_date');
            $table->string('publish_status')->default('Pendiente');
            $table->string('status')->default('Activo');

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_id')->references('id')->on('users');
        });

        Schema::create('gym_schedule', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('gym_id')->unsigned();
            $table->string('day_legend', 20)->default('');
            $table->string('day', 1)->default('');
            $table->time('start_time');
            $table->time('end_time');

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('gym_id')->references('id')->on('gym');
        });

        Schema::create('gym_service', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('gym_id')->unsigned();
            $table->integer('category_id')->unsigned();

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('category_id')->references('id')->on('category');
            $table->foreign('gym_id')->references('id')->on('gym');
        });

        Schema::create('gym_image', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('gym_id')->unsigned();
            $table->string('image', 50)->default('default.png');

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('gym_id')->references('id')->on('gym');
        });
    }

    public function down()
    {
        Schema::dropIfExists('gym_image');
        Schema::dropIfExists('gym_service');
        Schema::dropIfExists('gym_schedule');
        Schema::dropIfExists('gym');
    }
}
