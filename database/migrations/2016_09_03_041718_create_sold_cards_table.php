<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSoldCardsTable extends Migration
{
    public function up()
    {
        Schema::create('sold_cards', function (Blueprint $table) {
            $table->increments('id');
            $table->string('toot_card_id')->index();
            $table->float('price');
            $table->timestamps();

            $table->foreign('toot_card_id')
                ->references('id')
                ->on('toot_cards')
                ->onUpdate('cascade');
        });
    }

    public function down()
    {
        Schema::drop('sold_cards');
    }
}
