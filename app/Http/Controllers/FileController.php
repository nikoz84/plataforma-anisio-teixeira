<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Request;

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
    public function store (Request $request){
        $file = $request->file('imagem');
        dd($file);
    }
}
