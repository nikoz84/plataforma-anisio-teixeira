<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNewsletterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('content_pagina_inicial', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('Identificador unico e chave primaria');
            $table->increments('id');

            $table->text('conteudo')->comment('conteudo');


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
        Schema::dropIfExists('content_pagina_inicial');
    }
}
