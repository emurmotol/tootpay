<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSettingsTable extends Migration
{
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->string('key')->primary();
            $table->string('value');
        });
    }

    public function down()
    {
        Schema::drop('settings');
    }
}
