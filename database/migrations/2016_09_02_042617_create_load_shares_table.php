<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLoadSharesTable extends Migration
{
    public function up()
    {
        Schema::create('load_shares', function (Blueprint $table) {
            $table->increments('id');
            $table->string('from_toot_card_id')->index();
            $table->string('to_toot_card_id')->index();
            $table->float('load_amount');
            $table->timestamps();

            $table->foreign('from_toot_card_id')
                ->references('id')
                ->on('toot_cards')
                ->onUpdate('cascade');

            $table->foreign('to_toot_card_id')
                ->references('id')
                ->on('toot_cards')
                ->onUpdate('cascade');
        });
    }

    public function down()
    {
        Schema::drop('load_shares');
    }
}
