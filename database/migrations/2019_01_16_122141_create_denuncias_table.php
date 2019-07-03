<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDenunciasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('denuncias', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('Identificador unico e chave primaria da denuncia');
            $table->string('name', 100)->comment('Nome do denunciante');
            $table->string('email', 100)->comment('email do denunciante');
            $table->string('url', 250)->comment('Url do projeto');
            $table->string('subject', 140)->comment('assunto referente a denuncia');
            $table->text('message')->comment('mensagem referente a denuncia');
            // campos created_at e updated_at
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('denuncias');
    }
}
