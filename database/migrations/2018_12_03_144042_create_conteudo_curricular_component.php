<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

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
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->nullable()->default(null);

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
