<?php

namespace App\Jobs;

use App\Helpers\ContentVideoConvert;
use Streaming\FFMpeg;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

/**
 * Classe do tipo Job para executar em paralelo ao fluxo principal a execução de conversão dos arquivos de video 
 * dos conteudos digitais. A partir do formato mp4 para o formato de exibição de streaming.
 */
class VideoStreamingConvert implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $tries = 2;
    private ContentVideoConvert $converter;
    private string $pathDestiny;

    /**
     * Create a new job instance.
     * Crie uma nova instância de trabalho.
     * @return void
     */
    public function __construct(ContentVideoConvert $converter, string $path)
    {
        $this->converter = $converter;
        $this->pathDestiny = $path;
    }

    /**
     * Execute the job.
     * Execute o trabalho
     *
     * @return void
     */
    public function handle()
    {
        $ffmpeg = FFMpeg::create(config('ffmpeg'));
        $this->converter->convertToStreaming($this->pathDestiny, $ffmpeg);
    }
}
