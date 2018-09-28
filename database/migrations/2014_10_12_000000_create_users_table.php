<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('chave primaria do usuário');
            $table->string('name')->comment('Nome do usuário');;
            $table->string('email')->unique()->comment('Email do usuário');;
            $table->string('password')->comment('Senha do usuario');;
            $table->jsonb('options')->comment('Meta data do usuário');;
            $table->rememberToken()->comment('Cria Token quando esta logado');;
            $table->timestamps()->comment('Campos created_at e updated_at');;
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
