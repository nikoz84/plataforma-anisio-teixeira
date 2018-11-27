<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;

class FileController extends File
{
    public function getFiles($id)
    {
        //
    }
    public function createFile($id)
    {
        $request->file('imagem-destacada');
    }
    public function downloadFile($id)
    {
        //
    }
}
