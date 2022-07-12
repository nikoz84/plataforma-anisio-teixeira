<?php

namespace Database\Seeders;

use App\Models\CurricularComponent;
use Illuminate\Database\Seeder;

class CurricularComponentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        CurricularComponent::create([

            'name' => 'teste',
            'category_id' => null,
            'nivel_id' => 3
        ]);
    }
}