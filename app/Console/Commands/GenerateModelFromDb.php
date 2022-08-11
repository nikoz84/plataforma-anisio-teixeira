<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class GenerateModelFromDb extends Command
{
    /**
     * Nome e asinatura do comando
     *
     * @var string
     */
    protected $signature = 'map:model {tablename?} {tableschema?}';

    /**
     * Descicao do comando
     *
     * @var string
     */
    protected $description = 'Genera as clases a partir de uma tabela do banco';

    /**
     * Criar uma nova instancia do commando
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
        $tablename = $this->argument('tablename');
        $tableschema = $this->argument('tableschema');
        $where = '';
        if ($tablename) {
            $where = "where table_name='".$tablename."'";
        }
        if ($tableschema) {
            $where .= " and table_schema = '".$tableschema."'";
        }
        $selectSchema = 'select * from information_schema.tables '.$where;
        $tables = DB::select($selectSchema); // nomes das tabelas que quer exportar
        foreach ($tables as $table_schema) {
            $this->info($table_schema->table_name);
            $model = ucfirst($table_schema->table_name);
            echo $model.'-';
            $this->call('krlove:generate:model', [
                'class-name' => $model,
                '-tn' => 'escola.'.$table_schema->table_name,
                //"-op" => app_path('Models',"Configuracoes"),
                '-ns' => "App\Models\Escola",
            ]);
        }
    }
}
