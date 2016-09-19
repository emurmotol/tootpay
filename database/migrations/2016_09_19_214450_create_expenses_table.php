<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExpensesTable extends Migration
{
    public function up()
    {
        Schema::create('expenses', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->float('amount');
            $table->text('description');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::drop('expenses');
    }
}
