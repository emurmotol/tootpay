<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReloadTransactionTable extends Migration
{
    public function up()
    {
        Schema::create('reload_transaction', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('transaction_id')->unsigned();
            $table->integer('reload_id')->unsigned();
            $table->timestamps();

            $table->foreign('transaction_id')
                ->references('id')
                ->on('transactions')
                ->onDelete('cascade');

            $table->foreign('reload_id')
                ->references('id')
                ->on('reloads')
                ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::drop('reload_transaction');
    }
}
