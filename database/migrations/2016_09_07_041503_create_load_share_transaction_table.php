<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLoadShareTransactionTable extends Migration
{
    public function up()
    {
        Schema::create('load_share_transaction', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('transaction_id')->unsigned();
            $table->integer('load_share_id')->unsigned();
            $table->timestamps();

            $table->foreign('transaction_id')
                ->references('id')
                ->on('transactions')
                ->onDelete('cascade');

            $table->foreign('load_share_id')
                ->references('id')
                ->on('load_shares')
                ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::drop('load_share_transaction');
    }
}
