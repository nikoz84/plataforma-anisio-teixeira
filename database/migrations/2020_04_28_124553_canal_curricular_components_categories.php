<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CanalCurricularComponentsCategories extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('canal_cc_categories', function (Blueprint $table) {
            $table->bigInteger('canal_id');
            $table->bigInteger('category_id');

            $table->primary(['canal_id', 'category_id']);
            $table->foreign('canal_id')
                ->references('id')
                ->on('canais');
            $table->foreign('category_id')
                ->references('id')
                ->on('curricular_components_categories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('canal_cc_categories');
    }
}
