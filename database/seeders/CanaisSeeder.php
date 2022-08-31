<?php

namespace Database\Seeders;

use App\Models\Canal;
use Illuminate\Database\Seeder;

class CanaisSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Canal::create([
            'name' => 'Canal Teste',
            'description' => 'Teste inclusão de canal',
            'slug' => 'Teste Canal',
            'is_active' => true,
            'options' => []

        ]);
    }
}
