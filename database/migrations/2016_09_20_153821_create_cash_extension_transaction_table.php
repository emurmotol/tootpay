<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCashExtensionTransactionTable extends Migration
{
    public function up()
    {
        Schema::create('cash_extension_transaction', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('transaction_id')->unsigned();
            $table->integer('cash_extension_id')->unsigned();
            $table->timestamps();

            $table->foreign('transaction_id')
                ->references('id')
                ->on('transactions')
                ->onDelete('cascade');

            $table->foreign('cash_extension_id')
                ->references('id')
                ->on('cash_extensions')
                ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::drop('cash_extension_transaction');
    }
}
