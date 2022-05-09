<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers;

class DocumentsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		/* 	Schema::dropIfExists('documents');
		Schema::rename('documents'); */
		Schema::create('documents', function (Blueprint $table) {
			$table->bigIncrements('id')->comment('Chave primaria');
			$table->string('name', 155)->comment('Nome identificador do conteudo');
			$table->jsonb('document')->default('{}')->comment('Campo formato jsonb');
			// campo de data created_at and updated_at
			$table->timestamps();
			// campo de data deleted_at
			$table->softDeletes();
		});

		//DB::statement("SELECT setval('niveis_ensino_id_seq', (select max(id) from niveis_ensino)+1)");
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{

		Schema::dropIfExists('documents');
	}
}
