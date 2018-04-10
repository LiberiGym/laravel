<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{

    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('email', 100)->unique();

            // Facebook connect
            $table->string('registration_mode', 20)->default('email');
            $table->string('fb_token', 200)->default('');
            $table->string('fb_id', 20)->default('');

            // Personal info
            $table->string('name', 50);
            $table->string('middle_name', 50)->default('');
            $table->string('last_name', 50)->default('');
            $table->date('birth_date')->default('2000-01-01');
            $table->string('image', 50)->default('default.png');

            // Contact info
            $table->string('address', 100)->default('');
            $table->string('phone', 20)->default('');
            $table->string('home_phone', 20)->default('');
            $table->string('notes', 500)->default('');

            // Registration / recover
            $table->string('status', 20)->default('Activo');
            $table->string('registration_status', 20)->default('Pendiente');
            $table->string('registration_code', 5)->default('DEFA');
            $table->string('recover_code', 4)->default('AB01');
            $table->datetime('recover_before')->default('2017-01-01');

            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
}
