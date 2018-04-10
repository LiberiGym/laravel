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
            $table->string('image', 50)->default('default.png');
            $table->string('description', 255)->default('');
            $table->string('overview', 255)->default('');
            $table->longText('article');
            $table->string('tags', 100)->default('');
            $table->integer('views')->unsigned()->default('0');
            $table->datetime('publish_date');
            $table->boolean('programmed')->unsigned()->default('0');
            $table->string('publish_status')->default('Pendiente');
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
