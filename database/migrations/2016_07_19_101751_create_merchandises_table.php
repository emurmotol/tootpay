<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMerchandisesTable extends Migration
{
    public function up()
    {
        Schema::create('merchandise', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->float('price');
            $table->boolean('has_image')->default(false);
            $table->boolean('available')->default(false);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::drop('merchandise');
    }
}
