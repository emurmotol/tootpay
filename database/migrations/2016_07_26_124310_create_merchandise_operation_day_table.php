<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMerchandiseOperationDayTable extends Migration
{
    public function up()
    {
        Schema::create('merchandise_operation_day', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('merchandise_id')->unsigned();
            $table->string('operation_day_id')->nullable()->index();
            $table->timestamps();

            $table->foreign('merchandise_id')
                ->references('id')
                ->on('merchandises');

            $table->foreign('operation_day_id')
                ->references('id')
                ->on('operation_days');
        });
    }

    public function down()
    {
        Schema::drop('merchandise_operation_day');
    }
}
