<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCurricularComponentsCategories extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('curricular_components_categories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');

            // Indice
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
        Schema::dropIfExists('curricular_components_categories');
    }
}
