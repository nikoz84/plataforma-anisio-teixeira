<?php

namespace App\Console\Commands;

use App\Conteudo;
use Illuminate\Console\Command;
use App\Helpers\ContentVideoConvert;
use Illuminate\Support\Facades\Storage;
use App\Jobs\VideoStreamingConvert;
use Streaming\FFMpeg;

/**
 * Classe de comando para executar tarefa agendada de conversão de arquivos dos conteudos digitais para streaming
 */
class CommandConvertVideoStreming extends Command
{
    /**
     * Converte para Stream
     * @var string
     */
    protected $signature = 'convert:streaming';

    /**
     * Converte video de qualquer extensão para arquivos streaming.
     * @var string
     */
    protected $description = 'Coverte os conteudos do tipo video (tipo_id = 5) que estão na aplicação e possuem um arquivo de video mas não possuem o formato streming na pasta streming';

    /**
     * Create a new command instance.
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $conteudo = new Conteudo();
        $conteudosSemStreaming = $conteudo->conteudosSemStreamingFiles();
        $root = Storage::disk('conteudos-digitais')->path("streaming");
        $ffmpeg = FFMpeg::create(config('ffmpeg'));
        
        $converts = [];
        foreach($conteudosSemStreaming as $c)
        {
            $converts[] = new ContentVideoConvert( $c, $ffmpeg);
        }
        $sgesDelay = 60;
        foreach( $converts as $convert )
        {
            VideoStreamingConvert::dispatch($convert, $root)->delay(now()->addSeconds($sgesDelay));
            $sgesDelay += $sgesDelay;
        }
    }
}
