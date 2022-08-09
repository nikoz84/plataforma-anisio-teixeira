<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->bigInteger('role_id')->default(User::USER_DEFAULT_ROLE);
            $table->string('name')->comment('Nome do usuário');
            $table->string('email')->unique()->comment('Email do usuário');
            $table->string('password')->comment('Senha do usuário');
            $table->jsonb('options')->default('{}')->nullable()->comment('Metadados do usuário em formato json');
            $table->rememberToken()->comment('Se usuário permanece logado');
            $table->string('verification_token', 200)->nullable()->comment('Cadena de caracteres ramdomica');
            $table->boolean('verified')->default(User::USER_NOT_VERIFIED)->comment('Se usuário foi verificado');

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
        Schema::dropIfExists('users');
    }
}
