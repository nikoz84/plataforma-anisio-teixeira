<?php

namespace Database\Seeders;

use App\Models\Options;
use Illuminate\Database\Seeder;

class OptionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Options::create([
            'name' => 'Paises',
            'meta_data' => ['nome' => 'Brasil', 'uf' => 'Bahia, Rio de Janeiro, São Paulo']
        ]);
    }
}