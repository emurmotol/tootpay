<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReloadsTable extends Migration
{
    public function up()
    {
        Schema::create('reloads', function (Blueprint $table) {
            $table->increments('id');
            $table->float('load_amount');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::drop('reloads');
    }
}
