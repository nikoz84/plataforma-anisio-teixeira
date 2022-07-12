<?php

namespace Database\Seeders;

use App\Models\CurricularComponentCategory;
use Illuminate\Database\Seeder;

class CurricularComponentCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CurricularComponentCategory::create([
            'name' => 'Teste'
        ]);
    }
}