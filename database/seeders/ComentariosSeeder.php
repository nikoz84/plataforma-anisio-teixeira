<?php

namespace Database\Seeders;

use App\Models\Comentario;
use Illuminate\Database\Seeder;

class ComentariosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        Comentario::create([
            'conteudo_id' => 72,
            'aplicativo_id' => 4,
            'tipo' => 'Teste',
            'body' => 'Testando comentários',
            'user_id' => '4151'
        ]);
    }
}