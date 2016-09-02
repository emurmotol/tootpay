<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSoldCardTransactionTable extends Migration
{
    public function up()
    {
        Schema::create('sold_card_transaction', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('transaction_id')->unsigned();
            $table->integer('sold_card_id')->unsigned();
            $table->timestamps();

            $table->foreign('transaction_id')
                ->references('id')
                ->on('transactions')
                ->onDelete('cascade');

            $table->foreign('sold_card_id')
                ->references('id')
                ->on('sold_cards')
                ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::drop('sold_card_transaction');
    }
}
