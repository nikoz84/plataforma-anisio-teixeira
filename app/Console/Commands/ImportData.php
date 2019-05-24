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

        foreach ($files as $file) {
            if ($file->getExtension() == 'json') {
                $filename = pathinfo($file, PATHINFO_FILENAME);
                $data = file_get_contents($file);
                DB::statement("insert into options (name, meta_data) values ('$filename','$data')");
            } else {
                DB::statement("COPY {$file->getExtension()} FROM '{$file->getPathname()}' DELIMITER '*';");
            }
        }

        DB::statement("ALTER SEQUENCE users_id_seq RESTART WITH 2669;");
        DB::statement("ALTER SEQUENCE canais_id_seq RESTART WITH 15;");
        DB::statement("ALTER SEQUENCE tags_id_seq RESTART WITH 13877;");
        DB::statement("ALTER SEQUENCE aplicativos_id_seq RESTART WITH 126;");
        DB::statement("ALTER SEQUENCE conteudos_id_seq RESTART WITH 8670;");
        DB::statement("ALTER SEQUENCE licenses_id_seq RESTART WITH 14;");
        DB::statement("ALTER SEQUENCE categories_id_seq RESTART WITH 69;");
        DB::statement("ALTER SEQUENCE aplicativo_categories_id_seq RESTART WITH 16;");
        DB::statement("ALTER SEQUENCE niveis_ensino_id_seq RESTART WITH 12;");
    }
}
