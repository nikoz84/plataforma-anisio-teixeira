<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

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
            $table->bigInteger('tipo_id')->unsigned()->comment('Chave foranea do tipo de conteúdo');
            $table->bigInteger('canal_id')->unsigned()->nullable()->comment('Chave foranea do canal');
            $table->bigInteger('user_id')->unsigned()->comment('Chave foranea do usuario');
            $table->bigInteger('approving_user_id')->unsigned()->nullable()->comment('Chave foranea do usuario aprovador');
            $table->bigInteger('license_id')->unsigned()->comment('Chave foranea da licença do conteúdo');
            $table->bigInteger('category_id')->unsigned()->nullable()->comment('Chave foranea da categoria do conteúdo');
            $table->string('title', 250)->comment('Título do conteúdo');
            $table->text('description')->comment('Descrição do conteúdo');
            $table->text('authors')->comment('Autores do conteúdo, como regra devem se adicionar separados com ponto e vírgula');
            $table->text('source')->comment('Fonte do conteúdo');
            $table->text('accessibility')->nullable()->comment('Acessibilidade do conteúdo');
            $table->boolean('is_approved')->default(false)->comment('Se o conteúdo é aprovado');
            $table->boolean('is_featured')->default(false)->comment('Se o conteúdo é destaque');
            $table->boolean('is_site')->default(false)->comment('Se o conteuúdo é um site Temático');
            $table->integer('qt_downloads')->default(0)->nullable()->comment('Quantidade de downloads');
            $table->integer('qt_access')->default(0)->nullable()->comment('Quantidade de acessos');
            $table->jsonb('options')->default('{}')->nullable()->comment('Campo de formato jsonb para acrecentar meta dados do conteúdo');

            $table->timestamps();
            $table->softDeletes()->comment('Campo deleted_at para no apagar completamente o conteúdo');

            $table->index('id')->comment('indice para busca');
            $table->index('tipo_id')->comment('indice para busca');
            $table->index('canal_id')->comment('indice para busca');
            $table->index('category_id')->comment('indice para busca');
            $table->index('license_id')->comment('indice para busca');
            $table->index('user_id')->comment('indice para busca');
            $table->index('title')->comment('indice para titulo');

            $table->foreign('user_id')->references('id')->on('users')->comment('chave foranea do usuário');
            $table->foreign('tipo_id')->references('id')->on('tipos')->comment('chave foranea do tipo de conteúdo');
            $table->foreign('canal_id')->references('id')->on('canais')->comment('chave foranea do canal');
            $table->foreign('approving_user_id')->references('id')->on('users')->comment('chave foranea do usuário aprovador');
            $table->foreign('license_id')->references('id')->on('licenses')->comment('chave foranea do licença');
            $table->foreign('category_id')->references('id')->on('categories')->comment('chave foranea do da categoria');
        });
        // cria extensão sem acentos necesaria para full text search
        DB::statement('CREATE EXTENSION IF NOT EXISTS unaccent');
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
        Schema::dropIfExists('conteudos', function (Blueprint $table) {
            $table->dropIndex('conteudos_ts_documento_index');
            $table->dropIndex('conteudos_options_index');
        });
    }
}
