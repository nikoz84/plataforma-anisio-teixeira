<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateCanaisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('canais', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('Chave primaria e editificador unico do canal');
            $table->string('name', 155)->comment('Nome do canal');
            $table->text('description')->comment('Descrição do canal');
            $table->string('slug', 255)->unique()->comment('Url amigável do canal');
            $table->boolean('is_active')->default('false')->comment('Se o canal está ativo');
            $table->text('token')->nullable()->comment('Token de coneção com apis externas');
            $table->jsonb('options')->default('{}')->comment('Campo formato jsonb para acrecentar meta dados');
            // campo de data created_at and updated_at
            $table->timestamps();
            // campo de data deleted_at
            $table->softDeletes();
            // indices da tabela
            $table->index('id')->comment('indice para id');
            $table->index('name')->comment('indice para nome');
        });
        // gin indice invertido
        DB::statement('CREATE INDEX canais_options_index ON canais USING GIN (options jsonb_path_ops);');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('canais');
    }
}
