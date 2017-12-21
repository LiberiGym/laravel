<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CategoriesModule extends Migration
{

    public function up()
    {
        Schema::create('category', function(Blueprint $table)
        {
            $table->increments('id');
            $table->string('title', 50);
            $table->string('status')->default('Activo');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('category');
    }
}
