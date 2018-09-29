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
            $table->bigIncrements('id');
            $table->string('name', 100);
            $table->text('description');
            $table->string('slug', 100)->unique();
            $table->boolean('is_active')->default('false');
            // campo formato jsonb para acrecentar meta dados
            $table->jsonb('options')->default('{}')->nullable();
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
