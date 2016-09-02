<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSoldCardsTable extends Migration
{
    public function up()
    {
        Schema::create('sold_cards', function (Blueprint $table) {
            $table->increments('id');
            $table->float('price');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::drop('sold_cards');
    }
}
