<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(
            [
                UserSeeder::class,
                ContatoSeeder::class,
                AplicativoCategorySeeder::class,
                CanaisSeeder::class,
                AplicativoSeeder::class,
                //ComentariosSeeder::class,
                TipoSeeder::class,
                ConteudoSeeder::class,
                ConteudoLikeSeeder::class,
                CurricularComponentSeeder::class,
                CurricularComponentCategorySeeder::class,
                DocumentSeeder::class,
                LicenseSeeder::class,
                OptionsSeeder::class,
                NivelEnsino::class

            ]
        );
    }
}
