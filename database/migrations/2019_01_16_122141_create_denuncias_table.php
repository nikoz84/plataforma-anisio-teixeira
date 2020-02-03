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
            $table->bigIncrements('id')->comment('Identificador unico e chave primaria');
            $table->string('action', 50)->commet('Ação requisitada, falecosco, denuncia, reportar bug');
            $table->string('name', 100)->comment('Nome do usuário');
            $table->string('email', 100)->comment('email do usuário');
            $table->string('url', 250)->comment('Url');
            $table->string('subject', 140)->comment('assunto');
            $table->text('message')->comment('mensagem');
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
