<?php

namespace App\Console\Commands;

use App\Conteudo;
use Illuminate\Console\Command;
use App\Helpers\ContentVideoConvert;
use Illuminate\Support\Facades\Storage;
use App\Jobs\VideoStreamingConvert;
use Streaming\FFMpeg;

class ConvertVideoStreming extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'convert:streaming';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Coverte os conteudos do tipo video (tipo_id = 5) que estão na aplicação e possuem um arquivo de video mas não possuem o formato streming na pasta streming';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //
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
