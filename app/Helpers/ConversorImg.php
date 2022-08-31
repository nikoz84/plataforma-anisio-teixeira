<?php

namespace App\Helpers;

use Exception;
use Orbitale\Component\ImageMagick\Command;

/**
 * COnverte imagens para o formato webp, mas antes confere se url de referencia corresponde a uma imagem
 */
class ConversorImg
{
    public function converterImg($urlImg, $deleteOriginalFile = '', $urlDestino = '')
    {
        if (is_file($urlImg)) {
            if ($this->confereUrl($urlImg)) {
                $ext = $this->extensaoImagem($urlImg);
                $caminhoImg = $this->caminhoImagem($urlImg)."\n";
                if (! $urlDestino) {
                    $urlDestino = $caminhoImg;
                }
                switch ($ext) {
                    case 'png':
                        $this->converterPngParaWebp($urlImg, $urlDestino, $deleteOriginalFile);
                        break;
                    case 'jpeg':
                        $this->converterJpegParaWebp($urlImg, $urlDestino, $deleteOriginalFile);
                        break;
                    case 'gif':
                        $this->converterGifParaWebp($urlImg, $urlDestino, $deleteOriginalFile);
                        break;
                    case 'svg+xml':
                        $this->converterSvgParaWebp($urlImg, $urlDestino, $deleteOriginalFile);
                        break;
                    case 'svg':
                        $this->converterSvgParaWebp($urlImg, $urlDestino, $deleteOriginalFile);
                        break;
                    default:
                        echo "default img\n";
                }

                return true;
            }
        } elseif (is_dir($urlImg)) {
            $i = 1;
            foreach (scandir($urlImg) as $url) {
                if (($url) != '.' && ($url) != '..') {
                    $this->converterImg($urlImg.DIRECTORY_SEPARATOR.$url, $urlDestino);
                    $i++;
                    echo '{'.$url.'}'."\n";
                }
            }

            return true;
        } else {
            echo 'url não é nada:'.$urlImg;
        }

        return false;
    }

    public function confereUrl($urlImg)
    {
        if (! file_exists($urlImg)) {
            throw new Exception;
        }
        $mimetype = mime_content_type($urlImg);
        echo $mimetype."\n";
        if (strpos($mimetype, 'image') === false) {
            return false;
        }

        return true;
    }

    /**
     * @param  string  $urlImg
     * @return mixed
     */
    public function extensaoImagem($urlImagem)
    {
        if ($this->confereUrl($urlImagem)) {
            $mimetype = mime_content_type($urlImagem);

            return str_replace('image/', '', $mimetype);
        }

        return false;
    }

    public function caminhoImagem($urlImg)
    {
        $urlimage = str_replace(basename($urlImg), '', $urlImg);

        return $urlimage;
    }

    public function nomeBase($urlImg)
    {
        $nomeBase = basename($urlImg);
        $ext = $this->extensaoImagem($urlImg);
        if ($ext == 'svg+xml') {
            $ext = 'svg';
        }
        $nomeBase = str_replace('.'.$ext, '', $nomeBase);

        return $nomeBase;
    }

    private function imageCreate($urlImagemOrigem, $urlDestino, $img, $deleteOriginalFile)
    {
        imagepalettetotruecolor($img);
        imagealphablending($img, true);
        imagesavealpha($img, true);
        $realpath = $this->getRelativePath(__DIR__, $urlDestino);
        $realpath = str_replace('../../', '', $realpath);
        $nomebase = $this->nomeBase($urlImagemOrigem);
        echo ' nomebase:'.$nomebase;
        $newName = $nomebase.'.webp';
        echo "\nnewfile:[".$realpath.$newName.']';
        fopen($realpath.$newName, 'w');
        imagewebp($img, $realpath.$newName);
        if ($deleteOriginalFile == 'y') {
            unlink($urlImagemOrigem);
        }
    }

    public function converterPngParaWebp($urlImagemOrigem, $urlDestino, $deleteOriginalFile)
    {
        try {
            $img = imagecreatefrompng($urlImagemOrigem);
            $this->imageCreate($urlImagemOrigem, $urlDestino, $img, $deleteOriginalFile);
        } catch (Exception $e) {
            echo $e;
        }
    }

    public function converterJpegParaWebp($urlImagemOrigem, $urlDestino, $deleteOriginalFile)
    {
        try {
            $img = imagecreatefromjpeg($urlImagemOrigem);
            $this->imageCreate($urlImagemOrigem, $urlDestino, $img, $deleteOriginalFile);
        } catch (Exception $e) {
            echo $e;
        }
    }

    public function converterSvgParaWebp($urlImagemOrigem, $urlDestino, $deleteOriginalFile)
    {
        try {
            $realpath = $this->getRelativePath(__DIR__, $urlDestino);
            $realpath = str_replace('../../', '', $realpath);
            $nomebase = $this->nomeBase($urlImagemOrigem);
            $newName = $nomebase.'.webp';
            $command = new Command('C:\Program Files\ImageMagick-7.0.10-Q16-HDRI\magick.exe');
            echo 'originalfile:'.$urlImagemOrigem;
            echo " \nto:".$realpath.$newName." \n";
            //fopen($realpath.$newName, "w+");
            exec('magick convert '.$urlImagemOrigem.' '.$realpath.$newName);
            if ($deleteOriginalFile == 'y') {
                unlink($urlImagemOrigem);
            }
        } catch (Exception $e) {
            echo $e;
        }
    }

    public function converterGifParaWebp($urlImagemOrigem, $urlDestino, $deleteOriginalFile)
    {
        try {
            $img = imagecreatefromwbmp($urlImagemOrigem);
            $this->imageCreate($urlImagemOrigem, $urlDestino, $img, $deleteOriginalFile);
        } catch (Exception $e) {
            echo $e;
        }
    }

    public function getRelativePath($from, $to)
    {
        // some compatibility fixes for Windows paths
        $from = is_dir($from) ? rtrim($from, '\/').'/' : $from;
        $to = is_dir($to) ? rtrim($to, '\/').'/' : $to;
        $from = str_replace('\\', '/', $from);
        $to = str_replace('\\', '/', $to);

        $from = explode('/', $from);
        $to = explode('/', $to);
        $relPath = $to;

        foreach ($from as $depth => $dir) {
            // find first non-matching dir
            if ($dir === $to[$depth]) {
                // ignore this directory
                array_shift($relPath);
            } else {
                // get number of remaining dirs to $from
                $remaining = count($from) - $depth;
                if ($remaining > 1) {
                    // add traversals up to first matching dir
                    $padLength = (count($relPath) + $remaining - 1) * -1;
                    $relPath = array_pad($relPath, $padLength, '..');
                    break;
                } else {
                    $relPath[0] = './'.$relPath[0];
                }
            }
        }
        $relPath = implode('/', $relPath);

        return  substr($relPath, 0, -1);
    }
}
