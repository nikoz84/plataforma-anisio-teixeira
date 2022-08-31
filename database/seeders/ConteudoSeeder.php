<?php

namespace Database\Seeders;

use App\Models\Conteudo;
use Illuminate\Database\Seeder;
use App\Models\Tipo;

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
            'tipo_id' => (Tipo::inRandomOrder()->get()->first())->id,
            'canal_id' => 19,
            'user_id' => 1,
            'category_id' => 46,
            //'approving_user_id' => 1,
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
