<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\User::class, 200)->create();
        factory(App\Canal::class, 3)->create();
        factory(App\License::class, 3)->create();
        factory(App\Conteudo::class, 100)->create();
    }
}
