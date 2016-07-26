<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOperationDaysTable extends Migration
{
    public function up()
    {
        Schema::create('operation_days', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('day');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::drop('operation_days');
    }
}
