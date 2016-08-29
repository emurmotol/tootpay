<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMerchandisesTable extends Migration
{
    public function up()
    {
        Schema::create('merchandises', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('category_id')->unsigned()->nullable();
            $table->string('name');
            $table->float('price')->nullable();
            $table->boolean('has_image')->default(false);
            $table->timestamps();

            $table->foreign('category_id')
                ->references('id')
                ->on('categories');
        });
    }

    public function down()
    {
        Schema::drop('merchandises');
    }
}
