<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserTootCardTable extends Migration
{
    public function up()
    {
        Schema::create('user_toot_card', function (Blueprint $table) {
            $table->increments('id');
            $table->string('toot_card_id')->index();
            $table->string('user_id')->index();
            $table->timestamps();

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');

            $table->foreign('toot_card_id')
                ->references('id')
                ->on('toot_cards')
                ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::drop('user_toot_card');
    }
}
