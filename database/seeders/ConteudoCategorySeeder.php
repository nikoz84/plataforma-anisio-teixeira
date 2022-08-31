<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Canal;

class ConteudoCategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::create([
            'name' => 'Categoria Teste',
            'canal_id' => null, //(Canal::inRandomOrder()->get()->first())->id,
            'parent_id' => null,
            'options' => []
        ]);
    }
}
