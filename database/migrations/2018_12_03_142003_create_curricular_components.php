<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCurricularComponents extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('curricular_components', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('category_id')->nullable()->comment('identificador da categoria do componente curricular');
            $table->integer('nivel_id')->nullable()->comment('identificador do nível de ensino');
            $table->string('name');

            $table->foreign('nivel_id')->references('id')->on('niveis_ensino')->comment('chave foranea do nivel de ensino');
            $table->foreign('category_id')->references('id')->on('curricular_components_categories')->comment('chave foranea da categoria do componente curricular');

            $table->index('id')->comment('indice para id');
            $table->index('name')->comment('indice para nome');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('curricular_components');
    }
}
