<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->string('name', 100)->comment('Nome do canal');
            $table->text('description')->comment('Descrição do canal');
            $table->string('slug',100)->unique()->comment('Url amigavel do canal');
            $table->boolean('is_active')->default('false')->comment('Se o canal está ativo');
            $table->text('token')->nullable()->comment('Token de coneção com apis externas');
            $table->jsonb('options')->default('{}')->comment('Campo formato jsonb para acrecentar meta dados');
            // campo de data created_at and updated_at
            $table->timestamps();
            // campo de data deleted_at
            $table->softDeletes();
            
            // indices da tabela    
            $table->index('id');
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
