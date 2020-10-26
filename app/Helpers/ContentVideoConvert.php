<?php

namespace App\Helpers;

use App\Traits\FileSystemLogic;

use App\Conteudo ;
use Exception;
use Streaming\FFMpeg;
use Streaming\Representation;
use App\Helpers\ImageExtractionFromVideo;

/**
 * Classe de conversão de video do conteudo digital para um formato streaming
 */
class ContentVideoConvert
{
    use FileSystemLogic;

    private Conteudo $conteudo;
    private FFMpeg $ffmpeg;
    private ImageExtractionFromVideo $igmExVideo;
    

    function __construct(Conteudo $conteudo, FFMpeg $ffmpeg)
    {
        $this->ffmpeg = $ffmpeg;
        $this->conteudo = $conteudo;
    }

    /**
     * metodo que converte o video do conteudo, passado pelo construtor, para o formato de streaming.
     * recebe uma string indicando o caminho do conteudo dentro da pasta de arquivos
     * @param string $pathDestiny
     * @return array
     */
    function convertToStreaming($pathDestiny)
    {
        $id = $this->conteudo->id;
        $r_144p  = (new Representation)->setKiloBitrate(95)->setResize(256, 144);
        $r_360p  = (new Representation)->setKiloBitrate(276)->setResize(640, 360);
        $r_480p  = (new Representation)->setKiloBitrate(750)->setResize(854, 480);
        $file = $this->downloadFileConteudoReferencia($id);
        if (!file_exists($file)) {
            $file = $this->downloadFileConteudoReferencia($id);
        }
        if (!file_exists($file)) {
            throw new Exception("Arquivo não encontrado :".$file);
        }
        if(!in_array(mime_content_type($file), ImageExtractionFromVideo::$video_mime_types)) 
        {
            throw new Exception("Conteudo não possui video relacionado");
        }
        $rand = rand(5, 99999);
        $video = $this->ffmpeg->open($file);
        $name = "{$id}.{$rand}";
        $fileConteudoStreaming = "conteudo-".$id;
        $pathDestiny = $pathDestiny . DIRECTORY_SEPARATOR . $fileConteudoStreaming;
        if (!is_dir($pathDestiny)) {
            mkdir($pathDestiny);
        }    
        $hls = $video->hls()
        ->x264()
        ->addRepresentations([$r_144p, $r_480p])
        ->save("{$pathDestiny}/$name");
        $metadata = $hls->metadata();
        //mkdir("{$pathDestiny}/json/");
        //$metadata->saveAsJson("{$pathDestiny}/json/{$id}.json");
        return $metadata->export();
    }   

}