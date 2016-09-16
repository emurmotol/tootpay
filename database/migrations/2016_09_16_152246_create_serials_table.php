<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSerialsTable extends Migration
{
    public function up()
    {
        Schema::create('serials', function (Blueprint $table) {
            $table->string('tag');
            $table->timestamp('created_at');
        });
    }

    public function down()
    {
        Schema::drop('serials');
    }
}
