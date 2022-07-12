<?php

namespace Database\Seeders;

use App\Models\Aplicativo;
use Illuminate\Database\Seeder;

class AplicativoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Aplicativo::create([
            'user_id' => '2',
            'category_id' => '10',
            'canal_id' => '9',
            'name' => 'MeuTeste',
            'description' => 'Teste de aplicativos',
            'url' => 'http://www.meuteste.com.br',
        ]);
    }
}