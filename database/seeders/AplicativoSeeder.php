<?php

namespace Database\Seeders;

use App\Models\Aplicativo;
use Illuminate\Database\Seeder;
use App\Models\AplicativoCategory;
use App\Models\Canal;
use App\Models\User;

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
            'user_id' => (User::inRandomOrder()->get()->first())->id,
            'category_id' => (AplicativoCategory::inRandomOrder()->get()->first())->id,
            'canal_id' => (Canal::inRandomOrder()->get()->first())->id,
            'name' => 'MeuTeste',
            'description' => 'Teste de aplicativos',
            'url' => 'http://www.meuteste.com.br',
        ]);
    }
}
