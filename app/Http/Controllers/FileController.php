<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;

use Symfony\Component\HttpFoundation\Request;

use GuzzleHttp\Psr7\Request;

class FileController extends File
{
    public function getFiles($id)
    {
        //
    }

    public function createFile($id)
    {
        $request->file('imagem');
    }

    public function store(request $request)
    {
        if ($request->hasFile('imagem')) {
            $request->file('imagem');
        }
    }

    public function downloadFile($id)
    {
        //
    }

}
