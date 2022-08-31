<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Tipo;

class TipoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Tipo::create([
            'name' => 'Documento',
            'options' => []
        ]);

        Tipo::create([
            'name' => 'Vídeo',
            'options' => []
        ]);


        Tipo::create([
            'name' => 'Áudio',
            'options' => []
        ]);
    }
}
