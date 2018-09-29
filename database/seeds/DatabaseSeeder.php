<?php

use Illuminate\Database\Seeder;
use App\Traits\FakeData;

class DatabaseSeeder extends Seeder
{
    use FakeData;
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        /**
         * reinicia as sequências 
         */
        DB::statement("ALTER SEQUENCE aplicativos_id_seq RESTART WITH 1");
        DB::statement("ALTER SEQUENCE canais_id_seq RESTART WITH 1");
        DB::statement("ALTER SEQUENCE conteudos_id_seq RESTART WITH 1");
        DB::statement("ALTER SEQUENCE users_id_seq RESTART WITH 1");
        DB::statement("ALTER SEQUENCE tags_id_seq RESTART WITH 1");
        /**
         * inserta dados fakes no banco
         */
        $data = FakeData::getData();
        DB::table('users')->insert($data['users']);
        DB::table('canais')->insert($data['canais']);
        DB::table('conteudos')->insert($data['conteudos']);
        DB::table('aplicativos')->insert($data['aplicativos']);
        DB::table('tags')->insert($data['tags']);
    }
}
