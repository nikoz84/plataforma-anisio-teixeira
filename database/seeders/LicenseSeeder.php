<?php

namespace Database\Seeders;

use App\Models\License;
use Illuminate\Database\Seeder;

class LicenseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        License::create([
            'name' => 'teste',
            'description' => 'testando',
            'site' => 'http://www.teste.com.br',
            'parent_id' => 2
        ]);
    }
}