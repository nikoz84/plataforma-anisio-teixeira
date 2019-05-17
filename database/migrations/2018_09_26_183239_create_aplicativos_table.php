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
            $table->integer('user_id')->comment('Chave foranea do usuário publicador');
            $table->integer('category_id')->comment('Chave foranea da categoria');
            $table->integer('canal_id')->comment('Chave foranea do canal');
            $table->string('name', 150)->comment('Nome do aplicativo');
            $table->text('description')->comment('Descrição do aplicativo');
            $table->string('url', 150)->comment('Url do projeto');
            $table->jsonb('options')->default('{}')->nullable()->comment('Meta data do aplicativo');
            // campos created_at e updated_at
            $table->timestamps();
            // indice
            $table->index('id')->comment('btree index por default');
            //chaves foraneas
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('category_id')->references('id')->on('aplicativo_categories');
            $table->foreign('canal_id')->references('id')->on('canais');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('aplicativos', function (Blueprint $table) {
            $table->dropIndex('aplicativos_id_index');
        });
    }
}
