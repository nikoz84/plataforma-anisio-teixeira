<?php 
namespace App\Helpers;

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

	public function __construct()
	{
		# vga = 640×480
		$this->imageSize = 'vga';
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
		return shell_exec("ffmpeg -i {$this->videoPath} -r 1 -s {$this->imageSize} -f image2 -vframes 1 {$this->imagePathDestination}/{$this->createImageName()}-%03d.jpeg");
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