<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRolesTable extends Migration
{
    public function up()
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->string('name');
            $table->string('description');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::drop('roles');
    }
}
