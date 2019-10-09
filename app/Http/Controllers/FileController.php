<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\Http\Controllers\ApiController;
use App\Traits\FileSystemLogic;

class FileController extends ApiController
{
    use FileSystemLogic;

    public function __construct(File $file, Request $request, Storage $storage)
    {
        $this->middleware('jwt.verify')->except(['index', 'search', 'getFiles', 'getGallery']);
        $this->file = $file;
        $this->request = $request;
        $this->storage = $storage;
    }

    public function getFiles($id)
    {
        $exists = Storage::disk('aplicativos-educacionais')->exists('4.jpg');
        $files = Storage::disk('aplicativos-educacionais');

        return response()->json([
            'success' => $exists,
            'path' => 'app/public/conteudos/aplicativos-educacionais/',
            'disk', $files
        ]);
    }

    public function createFile($id)
    {
        if ($this->request->hasFile('image')) {
            $image = $this->request->file('image');
            $file_name = "{$id}.{$image->guessExtension()}";

            $path = $this->request->file('image')
                ->storeAs('imagem-associada', $file_name, 'aplicativos-educacionais');

            return response()->json([
                'success' => true,
                'message' => 'Arquivo enviado',
                'file' => $path
            ]);
        }
        return response()->json([
            'success' => false,
            'message' => 'Erro no envio do arquivo'
        ]);
    }

    public function store()
    {
        if ($this->request->hasFile('imagem')) {
            $this->request->file('imagem');
        }
    }

    public function downloadFile($id)
    {
        //
    }
    public function getGallery()
    {
        return $this->showAll($this->getImagesGallery(), 'Galeria de Imagens', 200);
    }
}
