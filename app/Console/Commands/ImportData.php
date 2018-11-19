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
        $users = storage_path('dumps\1_users');
        $canais = storage_path('dumps\2_canais');
        $tags = storage_path('dumps\3_tags');
        $aplicativos = storage_path('dumps\4_aplicativos');
        $aplicativo_tag = storage_path('dumps\5_aplicativo_tag');
        $conteudos = storage_path('dumps\6_conteudos');
        $conteudo_tag = storage_path('dumps\7_conteudo_tag');
        $licenses = storage_path('dumps\8_licenses');
        $category_conteudo = storage_path('dumps\9_category_conteudo');
        $componentes = explode("\n", file_get_contents(storage_path('dumps\10_componentes')));
        $niveis = explode("\n", file_get_contents(storage_path('dumps\11_niveis_ensino')));
        
        DB::statement("copy users FROM '{$users}' delimiter '*';");
        DB::statement("copy canais FROM '{$canais}' delimiter '*';");
        DB::statement("copy tags FROM '{$tags}' delimiter '*';");
        DB::statement("copy aplicativos FROM '{$aplicativos}' delimiter '*';");
        DB::statement("copy aplicativo_tag FROM '{$aplicativo_tag}' delimiter '*';");
        DB::statement("copy conteudos FROM '{$conteudos}' delimiter '*';");
        DB::statement("copy conteudo_tag FROM '{$conteudo_tag}' delimiter '*';");
        DB::statement("copy licenses FROM '{$licenses}' delimiter '*';");
        DB::statement("copy categories FROM '{$category_conteudo}' delimiter '*';");
        
        $this->importToOptions($componentes);
        $this->importToOptions($niveis);
    }

    private function importToOptions($meta_data)
    {
        foreach ($meta_data as $key => $value) {
            $data = explode("*", $value);
            DB::statement("insert into options (name, meta_data) values ('$data[0]','$data[1]')");
        }
    }
}
