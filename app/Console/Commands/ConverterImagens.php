<?php

namespace App\Console\Commands;

use App\Helpers\ConversorImg;
use Illuminate\Console\Command;

class ConverterImagens extends Command
{
    /**
     * Nome e asinatura do comando
     *
     * @var string
     */
    protected $signature = 'converter:img {urlOrigem} {deleteOrginalFile?} {urlDestino?}';

    /**
     * Descrição do comando
     *
     * @var string
     */
    protected $description = 'Transforma arquivo de imagem expecificado pela urlOrigem em um arquivo .webp em um destino opcional, ou na mesma pasta caso destino não for expecificado';

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
        $urlOrigem = $this->argument('urlOrigem');
        $urlDestino = $this->argument('urlDestino');
        $deleteOrginalFile = $this->argument('deleteOrginalFile');
        $conversor = new ConversorImg;
        $conversor->converterImg($urlOrigem, $deleteOrginalFile, $urlDestino);
    }
}
