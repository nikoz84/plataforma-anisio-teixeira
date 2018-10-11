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
            $table->bigIncrements('id')->comment('Identificador unico e chave primaria do aplicativo');
            $table->bigInteger('user_id')->comment('Chave foranea do usuário publicador');
            $table->string('name',200)->comment('Nome do aplicativo');
            $table->string('url',250)->comment('Url do projeto');
            $table->text('description')->comment('Descrição do aplicativo');
            $table->boolean('is_featured')->comment('Se o aplicativo é destaque');
            $table->jsonb('options')->default('{}')->nullable()->comment('Meta data do aplicativo');
            // campos created_at e updated_at
            $table->timestamps();
            // indice    
            $table->index('id')->comment('Btree index por default');
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
