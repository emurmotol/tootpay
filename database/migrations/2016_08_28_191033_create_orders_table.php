<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('merchandise_id')->unsigned();
            $table->integer('quantity');
            $table->float('total');
            $table->timestamps();

            $table->foreign('merchandise_id')
                ->references('id')
                ->on('merchandises');
        });
    }

    public function down()
    {
        Schema::drop('orders');
    }
}
