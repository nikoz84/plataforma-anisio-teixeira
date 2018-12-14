<?php

namespace App\Helpers;

use Intervention\Image\Image;

class ResizeImage
{

    public function resize($filePath, $fileName, $dir)
    {
        //Image::configure(config('image'));
        $img = Image::make($filePath)->resize(300, 200);

        $img->save($dir . $fileName, 70);
    }
}
