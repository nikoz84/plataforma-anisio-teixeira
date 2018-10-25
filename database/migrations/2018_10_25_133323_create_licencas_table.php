<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLicencasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('licencas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 255)->comment('Nome da licenca');
            $table->text('description')->comment('Descrição da Licença');
            $table->string('site', 255)->nullable()->comment('Url da licença');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('licencas');
    }
}
