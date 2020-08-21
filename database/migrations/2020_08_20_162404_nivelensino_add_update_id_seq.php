<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class NivelensinoAddUpdateIdSeq extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        DB::statement("SELECT setval('niveis_ensino_id_seq', (select max(id) from niveis_ensino)+1)");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        DB::statement("SELECT setval('niveis_ensino_id_seq', 1");
    }
}
