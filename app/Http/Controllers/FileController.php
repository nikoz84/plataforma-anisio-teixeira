<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\Http\Controllers\ApiController;
use App\Traits\FileSystemLogic;
use App\Conteudo;

class FileController extends ApiController
{
    use FileSystemLogic;

    public function __construct(File $file, Request $request, Storage $storage)
    {
        $this->middleware('jwt.verify')->except(['index', 'search', 'getFiles', 'getGallery', 'downloadFile']);
        $this->file = $file;
        $this->request = $request;
        $this->storage = $storage;
    }

    public function getFiles($id)
    {
        $exists = Storage::disk('public')->exists('logo.png');


        return response(['exist' => $exists], 200, ['Content-Type' => 'image/png']);
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

    public function downloadFile($action, $id)
    {
        $this->successResponse([ 'action' => $action, 'id'=> $id], 'as', 200);
        $directory = $action;

        $file = $this->getMetaDados($directory, $id);
        Conteudo::find($id)->increment('qt_downloads');

        $headers = ['Content-Type' => "application/{$file->mime_type}"];
        return Storage::disk('conteudos-digitais')->download("{$directory}/".$file->name, $file->name, $headers);
    }

    public function getGallery()
    {
        $imagens = collect($this->getImagesGallery(true));
        
        return $this->showAll($imagens);
    }
}
