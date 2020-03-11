<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Tag;

class CreateTagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tags', function (Blueprint $table) {
            $table->bigIncrements('id')->commet('Nome da tag deve ser única');
            $table->string('name', 120)->unique()->comment('Nome da tag deve ser única');
            $table->integer('searched')->default(Tag::INIT_SEARCHED)->nullable();
            $table->timestamps();
            $table->softDeletes();
            // Indices
            $table->index('id')->comment('indice para id');
            $table->index('name')->comment('indice para nome');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tags');
    }
}
