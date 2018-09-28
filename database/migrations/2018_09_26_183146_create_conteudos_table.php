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
            // ids
            $table->bigIncrements('id');
            $table->bigInteger('canal_id')->nullable();
            $table->bigInteger('user_id');
            // titulo
            $table->string('title',120);
            // aprovado
            $table->boolean('is_approved')->default('false');
            // destaque
            $table->boolean('is_featured')->default('false');
            // descrição
            $table->text('description');
            // autores e fonte
            $table->text('autores');
            $table->string('fonte',150);
            // campo formato jsonb para acrecentar meta dados
            $table->jsonb('options')->default('{}')->nullable();
            // campos created_at e updated_at
            $table->timestamps();
            //campo deleted_at
            $table->softDeletes();
            
            // indices da tabelas
            $table->index('id');
            // chave foranea
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('canal_id')->references('id')->on('canais');
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
