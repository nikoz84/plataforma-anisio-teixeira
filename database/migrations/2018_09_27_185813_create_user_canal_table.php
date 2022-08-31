<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserCanalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_canal', function (Blueprint $table) {
            $table->bigInteger('user_id');
            $table->bigInteger('canal_id');
            $table->primary(['user_id', 'canal_id']);

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('canal_id')->references('id')->on('canais');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_canal');
    }
}
