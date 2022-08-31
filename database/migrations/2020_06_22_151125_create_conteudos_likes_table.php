<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConteudosLikesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('conteudos_likes', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('Chave primaria');

            $table->bigInteger('user_id');
            $table->bigInteger('conteudo_id')->nullable();
            $table->bigInteger('aplicativo_id')->nullable();
            $table->string('tipo', 50);
            $table->boolean('like')->nullable();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('conteudo_id')->references('id')->on('conteudos');
            $table->foreign('aplicativo_id')->references('id')->on('aplicativos');

            // campo de data created_at and updated_at
            $table->timestamps();
            // campo de data deleted_at
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('conteudos_likes');
    }
}
