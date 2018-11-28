<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->increments('id')->comment('Chave primaria');
            $table->integer('parent_id')->nullable()->comment('Categoria pai');
            $table->integer('canal_id')->nullable()->comment('Categoria do canal');
            $table->string('name', 255)->comment('Nome da categoria');
            $table->jsonb('options')->nullable()->comment('Meta dados da categoria');
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
        Schema::dropIfExists('categories');
    }
}
