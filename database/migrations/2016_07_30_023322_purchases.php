<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Purchases extends Migration
{
    public function up()
    {
        Schema::create('purchases', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('order_id');
            $table->integer('merchandise_id')->unsigned();
            $table->string('toot_card_id')->index()->nullable();
            $table->string('user_id')->index()->nullable();
            $table->integer('quantity');
            $table->float('total');
            $table->timestamps();

            $table->foreign('merchandise_id')
                ->references('id')
                ->on('merchandises');

            $table->foreign('toot_card_id')
                ->references('id')
                ->on('toot_cards')
                ->onUpdate('cascade');

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onUpdate('cascade');
        });
    }

    public function down()
    {
        Schema::drop('purchases');
    }
}
