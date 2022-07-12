<?php

namespace Database\Seeders;

use App\Models\Conteudo;
use Illuminate\Database\Seeder;

class ConteudoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Conteudo::create([
            'tipo_id' => 5,
            'canal_id' => 19,
            'user_id' => 4150,
            'category_id' => 46,
            'approving_user_id' => 4150,
            'license_id' => 11,
            'title' => 'Teste de conteudo',
            'description' => 'Testando conteudo com seeds',
            'authors' => 'Reinaldo',
            'source' => 'Teste',
            'accessibility' => 'Legenda',
            'is_approved' => true,
            'is_featured' => true,
            'is_site' => true,
            'options' => ['site' => 'http://www.teste.com.br']

        ]);
    }
}