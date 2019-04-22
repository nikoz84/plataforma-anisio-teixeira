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
        factory(App\Tag::class, 100)->create();
        factory(App\Category::class, 15)->create();
        factory(App\Conteudo::class, 100)->create();
        
        $tags = App\Tag::all();

        App\Conteudo::all()->each(function ($conteudo) use ($tags) { 
            $conteudo->tags()->attach(
                $tags->random(rand(1, 99))->pluck('id')->toArray()
            ); 
        });
    }
}
