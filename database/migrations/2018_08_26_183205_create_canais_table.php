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
            $table->bigIncrements('id')->comment('Identificador do canal');
            $table->string('name', 100)->comment('Nome do Canal');
            $table->text('description')->comment('Descrição do canal');
            $table->string('slug', 100)->unique()->comment('Url amigável');
            $table->boolean('is_active')->default('false')->comment('Se o canal esta ativo ou não');
            $table->jsonb('options')->default('{}')->nullable()->comment('Meta dados em formato JSONB');
            // campo de data created_at and updated_at
            $table->timestamps();
            $table->softDeletes()->comment('Data quando é deletado - deleted_at');
            
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
