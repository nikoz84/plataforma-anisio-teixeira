<?php

namespace App\Helpers;

use Intervention\Image\ImageManagerStatic as Image;

class ResizeImage
{

    public function resize($path)
    {
        Image::configure(config('image'));

        $image = Image::make($path)
                        ->resize(310, 210);
        return $img->response('jpg');
    }
}
