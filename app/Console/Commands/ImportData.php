<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

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
        $users = storage_path('dumps/1.users');
        $canais = storage_path('dumps/2.canais');
        $tags = storage_path('dumps/3.tags');
        $aplicativos = storage_path('dumps/4.aplicativos');
        $aplicativo_tag = storage_path('dumps/5.aplicativo_tag');
        $conteudos = storage_path('dumps/6.conteudos');
        $conteudo_tag = storage_path('dumps/7.conteudo_tag');
        $licenses = storage_path('dumps/8.licenses');
        $categories = storage_path('dumps/9.categories');
        $componentes = explode("\n", file_get_contents(storage_path('dumps/10.componentes')));
        $niveis = explode("\n", file_get_contents(storage_path('dumps/11.niveis')));
        
        DB::statement("COPY users FROM '{$users}' DELIMITER '*';");
        DB::statement("COPY canais FROM '{$canais}' DELIMITER '*';");
        DB::statement("COPY tags FROM '{$tags}' DELIMITER '*';");
        DB::statement("COPY aplicativos FROM '{$aplicativos}' DELIMITER '*';");
        DB::statement("COPY aplicativo_tag FROM '{$aplicativo_tag}' DELIMITER '*';");
        DB::statement("COPY conteudos FROM '{$conteudos}' DELIMITER '*';");
        DB::statement("COPY conteudo_tag FROM '{$conteudo_tag}' DELIMITER '*';");
        DB::statement("COPY licenses FROM '{$licenses}' DELIMITER '*';");
        DB::statement("COPY categories FROM '{$categories}' DELIMITER '*';");
        
        DB::statement("ALTER SEQUENCE users_id_seq RESTART WITH 2668;");
        DB::statement("ALTER SEQUENCE canais_id_seq RESTART WITH 15;");
        DB::statement("ALTER SEQUENCE tags_id_seq RESTART WITH 13877;");
        DB::statement("ALTER SEQUENCE aplicativos_id_seq RESTART WITH 125;");
        DB::statement("ALTER SEQUENCE conteudos_id_seq RESTART WITH 8670;");
        DB::statement("ALTER SEQUENCE licenses_id_seq RESTART WITH 14;");
        DB::statement("ALTER SEQUENCE categories_id_seq RESTART WITH 69;"); 

        $this->importToOptions($componentes);
        $this->importToOptions($niveis);
    }

    private function importToOptions($meta_data)
    {
        foreach ($meta_data as $key => $value) {
            $data = explode("*", $value);
            DB::statement("insert into options (name, meta_data) values ('{$data[0]}','{$data[1]}')");
        }
    }
}
