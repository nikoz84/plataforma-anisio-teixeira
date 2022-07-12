<?php

namespace Database\Seeders;

use App\Models\Contato;
use Illuminate\Database\Seeder;

class ContatoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Contato::create([

            'name' => 'Reinaldo Santos',
            'email' => 'contato@teste.com.br',
            'message' => 'Teste de criação de seeds',
            'subject' => 'Testando seed',
            'action' => 'faleconosco',
            'url' => 'http://www.teste.com.br'
        ]);
    }
}