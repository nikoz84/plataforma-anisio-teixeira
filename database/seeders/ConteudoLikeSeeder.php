<?php

namespace Database\Seeders;

use App\Models\ConteudoLike;
use Illuminate\Database\Seeder;

class ConteudoLikeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        ConteudoLike::create([
            'user_id' => 450,
            'conteudo_id' => 72,
            'aplicativo_id' => 63,
            'tipo' => 1,
            'like' => true,
        ]);
    }
}