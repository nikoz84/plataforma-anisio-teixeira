<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class ImportData extends Command
{
    /**
     * Nome e asinatura do comando
     *
     * @var string
     */
    protected $signature = 'import:data';

    /**
     * Descrição do comando
     * @var string
     */
    protected $description = 'Carga do Banco de dados';

    /**
     * Criar uma nova instância do commando
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Executar o comando
     *
     * @return mixed
     */
    public function handle()
    {
        $files = array_sort(File::files(storage_path('dumps')), function ($file) {
            return $file->getFilename();
        });
        $this->info('Importando dados esper um momento...');
        
        foreach ($files as $file) {
            if ($file->getExtension() == 'json') {
                $filename = pathinfo($file, PATHINFO_FILENAME);
                $data = file_get_contents($file);
                DB::statement("insert into options (name, meta_data) values ('$filename','$data')");
                $option = strtoupper($filename);
                $this->info("Opção: {$option} criada com sucesso!!");
            } else {
                DB::statement("COPY {$file->getExtension()} FROM '{$file->getPathname()}' DELIMITER '*';");
                $tabela = strtoupper($file->getExtension());
                $this->line("Tabela: $tabela copiada com successo!!");
            }
        }
        
        $this->info('Reiniciando sequencias');
        DB::statement("ALTER SEQUENCE users_id_seq RESTART WITH 2675;");
        DB::statement("ALTER SEQUENCE canais_id_seq RESTART WITH 16;");
        DB::statement("ALTER SEQUENCE tags_id_seq RESTART WITH 15018;");
        DB::statement("ALTER SEQUENCE aplicativos_id_seq RESTART WITH 126;");
        DB::statement("ALTER SEQUENCE conteudos_id_seq RESTART WITH 12000;");
        DB::statement("ALTER SEQUENCE licenses_id_seq RESTART WITH 14;");
        DB::statement("ALTER SEQUENCE categories_id_seq RESTART WITH 69;");
        DB::statement("ALTER SEQUENCE aplicativo_categories_id_seq RESTART WITH 16;");
        DB::statement("ALTER SEQUENCE niveis_ensino_id_seq RESTART WITH 12;");
        DB::statement("ALTER SEQUENCE roles_id_seq RESTART WITH 8;");
        DB::statement("ALTER SEQUENCE aplicativo_categories_id_seq RESTART WITH 40;");
        DB::statement("ALTER SEQUENCE tipos_id_seq RESTART WITH 20;");


        $this->info('Atualizando Canais');
        DB::statement("UPDATE conteudos set canal_id = 6 where is_site = false and canal_id is null;");
        DB::statement("UPDATE conteudos set canal_id = 5 where is_site = true and canal_id is null;");
        DB::statement("UPDATE canais set is_active = false where  id  IN (4,10,11,13,14,15);");
        DB::statement("UPDATE canais set name = 'Recursos Educacionais' where id = 6;");
        DB::statement("UPDATE tipos set name = 'Documento' where id = 1");
        DB::statement("UPDATE canais set is_active = false where id = 8");
        DB::statement("UPDATE tipos set name = 'Animação' where id = 7");
        $this->info('Adicionando Temas contenporâneos');
        
        
        $this->createInitSlider();

        $this->info('Processo finalizado com sucesso');
    }

    private function createInitSlider()
    {
        //$url = env('APP_URL');

        \App\Options::create([
            'name' => 'slider',
            'meta_data' => [
                [
                    'image' => "/storage/conteudos/slider/banner-rotinas-de-estudo.png",
                    'filename' => 'banner-rotinas-de-estudo.png',
                    'url' => "/rotinas-de-estudo",
                    'title' => 'Canal de rotinas de estudo'
                ],
                [
                    'image' => "/storage/conteudos/slider/banner-ensino-superior.png",
                    'filename' => 'banner-ensinosuperior.png',
                    'url' => "/ipes",
                    'title' => 'Canal de ensino superior'
                ]
            ]
        ]);
    }
}
