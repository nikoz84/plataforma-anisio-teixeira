<?php 
namespace App\Helpers;

use Exception;

/*
* Esta classe é usada para extrair frame de um vídeo utilizando comandos do Software FFmpeg
* Forma da extração: Extrai um frame por video de forma aleatória, ou seja, extrai qualquer frame do vídeo.
* Obs: É necessário ter o FFmpeg instalado e configurado no seu embiente de execução
*/
class ImageExtractionFromVideo
{
    protected $imageSize;
    protected $videoPath;
    protected $imagePathDestination;
    protected $videoId;
    public static $video_mime_types = [
        'application/annodex',
        'application/mp4',
        'application/ogg',
        'application/vnd.rn-realmedia',
        'application/x-matroska',
        'video/3gpp',
        'video/3gpp2',
        'video/annodex',
        'video/divx',
        'video/flv',
        'video/h264',
        'video/mp4',
        'video/mp4v-es',
        'video/mpeg',
        'video/mpeg-2',
        'video/mpeg4',
        'video/ogg',
        'video/ogm',
        'video/quicktime',
        'video/ty',
        'video/vdo',
        'video/vivo',
        'video/vnd.rn-realvideo',
        'video/vnd.vivo',
        'video/webm',
        'video/x-bin',
        'video/x-cdg',
        'video/x-divx',
        'video/x-dv',
        'video/x-flv',
        'video/x-la-asf',
        'video/x-m4v',
        'video/x-matroska',
        'video/x-motion-jpeg',
        'video/x-ms-asf',
        'video/x-ms-dvr',
        'video/x-ms-wm',
        'video/x-ms-wmv',
        'video/x-msvideo',
        'video/x-sgi-movie',
        'video/x-tivo',
        'video/avi',
        'video/x-ms-asx',
        'video/x-ms-wvx',
        'video/x-ms-wmx',
    ];
    # vga = 640×480
    public const VGA_IMAGESCALE="vga";
    public const WXH_IMAGESCALE="WxH";

    /**
    * verifica se arquivo é mesmo um video
     * @return boolean
     */
    private function verificaVideo()
    {
        if (in_array(mime_content_type($this->videoPath), self::$video_mime_types)) {
            return true;
        }
        return false;
    }

    public function __construct($videoPath = null, $videoId = null, $imagePathDestination = "", $imageSize = "vga")
    {
        $this->setImageSize($imageSize);
        $this->setVideoPath($videoPath);
        $this->setVideoId($videoId);
        $this->setImagePathDestination($imagePathDestination);
    }
    /**
    * Recebe o id do Video, este id é usado para formar o nome da imagem que será gerada
    * @return void
    */
    public function setVideoId($videoId)
    {
        $this->videoId = $videoId;
    }
    
    /**
    * Seta o tamanho que a imagem tera ao ser gerada
    * @return void
    */
    public function setImageSize($size)
    {
        $this->imageSize = $size;
    }
    
    /**
    * Seta o caminho completo do video juntamente com a extensao
    * @return void
    */
    public function setVideoPath($path)
    {
        $this->videoPath = $path;
    }
    
    /**
    * Seta o caminho em que a imgem gerada será salva
    * @return void
    */
    public function setImagePathDestination($pathDestination)
    {
        $this->imagePathDestination = $pathDestination;
    }
    
    /**
    * Realiga a extração da imagem utilizando comando do software FFmpeg
    * @return void
    */
    public function extract()
    {
    # Executa o comando três vezes e extrai uma imagem em momentos diferentes após o inicio do video
        $this->realXtract('30');
        $this->realXtract('40');
        $this->realXtract('50');
    }
    
    /**
    * Metodo que executa o comando FFmpeg
    * @param $second: Representa a quantos segunos após o inicio do video as imagens serão extraidas
    */
    public function realXtract($second)
    {
        if (!is_file($this->videoPath)) {
            throw new Exception("Caminho fornecido:".$this->videoPath." não é um arquivo, tão pouco de video.", 501);
        }
        if (!$this->verificaVideo($this->videoPath)) {
            throw new Exception("Arquivo:".$this->videoPath." não é um arquivo de video.", 501);
        }
        if (!is_dir($this->imagePathDestination)) {
            throw new Exception("Caminho:".$this->imagePathDestination." não é um diretório de destino válido para salvar frame de video.", 501);
        }
        $command = "ffmpeg -itsoffset -{$second} -i {$this->videoPath} -r 1 -s {$this->imageSize} -f image2 -vframes 1 {$this->imagePathDestination}". DIRECTORY_SEPARATOR ."{$this->createImageName()}-%03d.jpeg";
        
        shell_exec($command);
    }
    
    /**
    * Cria um nome para a imagem que será salva
    * @return String
    */
    private function createImageName()
    {
        return $this->videoId.'.'.rand();
    }
}
