<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMerchandisesTable extends Migration
{
    public function up()
    {
        Schema::create('merchandises', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('merchandise_category_id')->nullable();
            $table->string('name');
            $table->float('price');
            $table->boolean('has_image')->default(false);
            $table->timestamps();

            $table->foreign('merchandise_category_id')
                ->references('id')
                ->on('merchandise_categories');
        });
    }

    public function down()
    {
        Schema::drop('merchandises');
    }
}
