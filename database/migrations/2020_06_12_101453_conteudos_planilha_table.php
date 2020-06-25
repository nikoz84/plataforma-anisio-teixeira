<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ConteudosPlanilhaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('conteudos_planilha', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('Chave primaria');
            $table->string('name', 155)->comment('Nome identificador do conteudo');
            $table->jsonb('document')->default('{}')->comment('Campo formato jsonb');
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
        Schema::dropIfExists('conteudos_planilha');
    }
}
