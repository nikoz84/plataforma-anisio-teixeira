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
            $table->bigIncrements('id')->comment('Chave primaria do usuário');
            $table->string('name')->comment('Nome do usuário');
            $table->string('email')->unique()->comment('Email do usuário');
            $table->string('password')->comment('Senha do usuário');
            $table->jsonb('options')->default('{}')->nullable()->comment('Metadados do usuário em formato json');
            $table->rememberToken();
            $table->timestamps();
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
