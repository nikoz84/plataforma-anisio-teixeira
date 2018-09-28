<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('options', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nome');
            // meta data
            $table->jsonb('meta_data')->default('{}')->nullable();
        });

        DB::statement('CREATE INDEX options_meta_data_index ON options USING GIN (meta_data jsonb_path_ops);');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('options',function(Blueprint $table){
            $table->dropIndex('options_meta_data_index');
        });
    }
}
