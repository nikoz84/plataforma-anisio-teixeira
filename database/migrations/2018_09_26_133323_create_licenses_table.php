<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLicensesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
        Schema::create('licenses', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('parent_id')->nullable()->comment('Licença pai');
            $table->string('name', 255)->comment('Nome da licenca');
            $table->text('description')->comment('Descrição da Licença');
            $table->string('site', 255)->nullable()->comment('Url da licença');
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
        Schema::dropIfExists('licenses');
    }
}
