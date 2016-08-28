<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransactionsTable extends Migration
{
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('queue_number')->nullable();
            $table->integer('payment_method_id')->unsigned();
            $table->integer('status_response_id')->unsigned();
            $table->timestamps();

            $table->foreign('payment_method_id')
                ->references('id')
                ->on('payment_methods');

            $table->foreign('status_response_id')
                ->references('id')
                ->on('status_responses');
        });
    }

    public function down()
    {
        Schema::drop('transactions');
    }
}
