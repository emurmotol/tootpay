<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCashExtensionsTable extends Migration
{
    public function up()
    {
        Schema::create('cash_extensions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('toot_card_id')->index();
            $table->float('amount');
            $table->timestamps();

            $table->foreign('toot_card_id')
                ->references('id')
                ->on('toot_cards')
                ->onUpdate('cascade');
        });
    }

    public function down()
    {
        Schema::drop('cash_extensions');
    }
}
