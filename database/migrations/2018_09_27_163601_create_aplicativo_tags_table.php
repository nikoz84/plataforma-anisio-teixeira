<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAplicativoTagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('aplicativo_tags', function (Blueprint $table) {
            $table->bigInteger('aplicativo_id');
            $table->bigInteger('tag_id');

            $table->primary(['aplicativo_id', 'tag_id']);
            $table->foreign('aplicativo_id')->references('id')->on('aplicativos');
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
        Schema::dropIfExists('aplicativo_tags');
    }
}
