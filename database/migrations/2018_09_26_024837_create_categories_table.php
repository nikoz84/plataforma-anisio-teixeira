<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('Chave primaria');
            $table->integer('parent_id')->nullable()->comment('Categoria pai');
            $table->integer('canal_id')->nullable()->comment('Categoria do canal');
            $table->string('name', 255)->comment('Nome da categoria');
            $table->jsonb('options')->nullable()->comment('Meta dados da categoria');

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('canal_id')->references('id')->on('canais')->comment('chave foranea do canal');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('categories');
    }
}
