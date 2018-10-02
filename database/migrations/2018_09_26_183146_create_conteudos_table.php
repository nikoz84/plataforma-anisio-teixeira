<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Symfony\Component\Console\Helper\Table;

class CreateConteudosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('conteudos', function (Blueprint $table) {
            
            $table->bigIncrements('id')->comment('Identificador único e chave primaria do conteúdo');
            $table->bigInteger('canal_id')->nullable()->comment('Chave foranea do canal');
            $table->bigInteger('user_id')->comment('Chave foranea do usuario');
            $table->string('title',120)->comment('Título do conteúdo');
            $table->boolean('is_approved')->default('false')->comment('Se o conteúdo é aprovado');
            $table->boolean('is_featured')->default('false')->comment('Se o conteúdo é destaque');
            $table->text('description')->comment('Descrição do conteúdo');
            $table->text('autores')->comment('Autores do conteúdo, como regra devem se adicionar separados com ponto e vírgula');
            $table->string('fonte',150)->comment('Fonte do conteúdo');
            $table->jsonb('options')->default('{}')->nullable()->comment('Meta dados do conteúdo em formato JSONB');
            // cria campos created_at e updated_at
            $table->timestamps();
            $table->softDeletes()->comment('Campo deleted_at para no apagar completamente o conteúdo');
            
            $table->index('id')->comment('indice para busca');
            $table->foreign('user_id')->references('id')->on('users')->comment('chave foranea do usuário');
            $table->foreign('canal_id')->references('id')->on('canais')->comment('chave foranea do canal');;
        });

        // coluna para full text search
        DB::statement("ALTER TABLE conteudos ADD COLUMN ts_documento TSVECTOR;");
        // indices para full text search e documento jsonb
        DB::statement('CREATE INDEX conteudos_ts_documento_index ON conteudos USING GIN (ts_documento);');
        DB::statement('CREATE INDEX conteudos_options_index ON conteudos USING GIN (options jsonb_path_ops);');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('conteudos', function(Blueprint $table){
            $table->dropIndex('conteudos_ts_documento_index');
            $table->dropIndex('conteudos_options_index');
        });
    }
}
