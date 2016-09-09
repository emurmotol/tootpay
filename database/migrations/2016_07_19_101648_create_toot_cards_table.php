<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTootCardsTable extends Migration
{
    public function up()
    {
        Schema::create('toot_cards', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('uid')->unique();
            $table->string('pin_code')->nullable();
            $table->float('load')->nullable();
            $table->float('points')->nullable();
            $table->boolean('is_active')->default(false);
            $table->timestamp('expires_at')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::drop('toot_cards');
    }
}
