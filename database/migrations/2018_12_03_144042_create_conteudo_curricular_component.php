<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConteudoCurricularComponent extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('conteudo_curricular_component', function (Blueprint $table) {
            $table->bigInteger('conteudo_id');
            $table->bigInteger('curricular_component_id');

            $table->primary(['conteudo_id', 'curricular_component_id']);
            $table->foreign('conteudo_id')->references('id')->on('conteudos');
            $table->foreign('curricular_component_id')->references('id')->on('curricular_components');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('conteudo_curricular_component');
    }
}
