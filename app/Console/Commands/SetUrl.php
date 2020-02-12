<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class SetUrl extends Command
{
    /**
     * Nome e asinatura do comando
     *
     * @var string
     */
    protected $signature = 'publish:url';

    /**
     * Descrição do comando
     * @var string
     */
    protected $description = 'Adiciona no arquivo bootstrap.js a url de destino da app';

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
        $file = resource_path("assets/js/bootstrap.js");
        $content = file_get_contents($file);
        $this->info('APP_URL: ' . env('APP_URL'));
        $str = preg_replace("/PUBLISH_URL/i", env('APP_URL'), $content);
        file_put_contents($file, $str);
        $this->info('URL PUBLICADA COM SUCESSO!');
    }
}
