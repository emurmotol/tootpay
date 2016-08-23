<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTootCardReloadTable extends Migration
{
    public function up()
    {
        Schema::create('toot_card_reload', function (Blueprint $table) {
            $table->increments('id');
            $table->string('toot_card_id')->index();
            $table->string('user_id')->index();
            $table->float('amount');
            $table->string('status')->nullable();
            $table->timestamps();

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
        Schema::drop('toot_card_reload');
    }
}
