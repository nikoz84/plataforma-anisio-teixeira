<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAplicativosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('aplicativos', function (Blueprint $table) {
            // ids
            $table->bigIncrements('id');
            $table->bigInteger('user_id');
            // campos
            $table->string('name',120);
            $table->text('description');
            $table->boolean('is_featured');
            // campo formato jsonb para acrecentar meta dados
            $table->jsonb('options')->default('{}')->nullable();
            // campos created_at e updated_at
            $table->timestamps();
            // indice    
            $table->index('id');
            // chave foranea usuario
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('aplicativos', function(Blueprint $table){
            $table->dropIndex('aplicativos_id_index');
        });
        
    }
}
