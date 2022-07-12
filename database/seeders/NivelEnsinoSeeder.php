<?php

namespace Database\Seeders;

use App\Models\NivelEnsino;
use Illuminate\Database\Seeder;

class NivelEnsinoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        NivelEnsino::create([
            'name' => 'Linguagen de Programação'
        ]);
    }
}