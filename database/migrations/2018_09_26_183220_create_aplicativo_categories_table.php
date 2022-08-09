<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAplicativoCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('aplicativo_categories', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('canal_id')->default(9)->comment('Categorias do canal aplicativos educacionais');
            $table->string('name', 250)->unique()->comment('Nome da categoria');
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
        Schema::dropIfExists('aplicativo_categories');
    }
}
