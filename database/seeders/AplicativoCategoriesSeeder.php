<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AplicativoCategory;

class AplicativoCategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        AplicativoCategory::create([
            'name' => 'Categoria Teste',
            'canal_id' => 9
        ]);
    }
}