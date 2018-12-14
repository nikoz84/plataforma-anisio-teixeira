<?php

namespace App\Helpers;

use Image;
use Storage;
use File;

class ResizeImage
{

    public function resize($filePath, $fileName, $dir)
    {
        $img = Image::make($filePath);
        $img->resize(300, 200);
        $img->save($dir . $fileName, 70);
    }
    public function resizeDirAplicativos()
    {
        $files = Storage::disk('aplicativos-educacionais')->allFiles('imagem-associada');
        $dir = Storage::disk('aplicativos-educacionais')->getDriver()->getAdapter()->getPathPrefix() . "imagem-associada/";

        foreach ($files as $file) {
            $ext= File::extension($file);
            $name = File::name($file);
            if ($ext == 'jpg') {
                $img = Image::make(Storage::disk('aplicativos-educacionais')->getDriver()->getAdapter()->getPathPrefix().$file);
                $img->resize(300, 200);
                $img->save($dir. $name.".".$ext, 80);
            } elseif ($ext == 'png') {
                Storage::disk('aplicativos-educacionais')->delete("imagem-associada/$name.png");
            } else {
                Storage::disk('aplicativos-educacionais')->delete("imagem-associada/$name.$ext");
            }
        }
    }
}
