<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAplicativoTagTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('aplicativo_tag', function (Blueprint $table) {
            $table->bigInteger('aplicativo_id');
            $table->bigInteger('tag_id');

            $table->primary(['aplicativo_id', 'tag_id']);
            $table->foreign('aplicativo_id')->references('id')->on('aplicativos')->onDelete('cascade');
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
        Schema::dropIfExists('aplicativo_tag');
    }
}
