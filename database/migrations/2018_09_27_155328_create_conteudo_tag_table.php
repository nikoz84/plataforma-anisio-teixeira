<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConteudoTagTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('conteudo_tag', function (Blueprint $table) {
            $table->bigInteger('conteudo_id');
            $table->bigInteger('tag_id');

            $table->primary(['conteudo_id', 'tag_id']);
            $table->foreign('conteudo_id')->references('id')->on('conteudos');
            $table->foreign('tag_id')->references('id')->on('tags');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('conteudo_tag');
    }
}
