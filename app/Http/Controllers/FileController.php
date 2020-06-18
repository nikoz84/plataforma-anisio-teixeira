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
        $this->middleware('jwt.auth')->except(['index', 'search', 'getFiles', 'getGallery', 'downloadFile', 'getInfoFolder']);
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

    public function downloadFile($directory, $id)
    {
        $conteudo = Conteudo::find($id);
        $conteudo->increment('qt_downloads');
        $file = null;
        switch ($directory) {
            case 'download':
                $file = $conteudo->arquivos['download'];
                break;
            case 'visualizacao':
                $file = $conteudo->arquivos['visualizacao'];
                break;
            case 'guias-pedagogicos':
                $file = $conteudo->arquivos['guias-pedagogicos'];
                break;
            default:
                return $this->errorResponse([], 'arquivo não encontrado', 404);
                break;
        }

        $headers = [
            "Content-Type" => "$file->mime_type"
        ];

        $path = self::windowsDirectory(
            Storage::disk('conteudos-digitais')->path("{$directory}/{$file->name}")
        );

        return response()->download($path, $file->name, $headers);
    }

    public function getGallery()
    {
        $imagens = collect($this->getImagesGallery(true));

        return $this->showAll($imagens);
    }


    public function getInfoFolder($directory, $directory2 = null, $directory3 = null)
    {
        if ($directory == 'public')
            $path = storage_path('app' . DIRECTORY_SEPARATOR . $directory . DIRECTORY_SEPARATOR . $directory2 . DIRECTORY_SEPARATOR . $directory3);
        else
            $path = storage_path('app' . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . $directory . DIRECTORY_SEPARATOR . $directory2 . DIRECTORY_SEPARATOR . $directory3);

        $files = scandir($path);

        $qtdFiles = count($files) - 2;

        $dirFiles = array();

        foreach ($files as $file) {
            if (($file == '.') || ($file == '..')) continue;

            $filename = $path . DIRECTORY_SEPARATOR . $file;
            $dirName = explode('\public', $filename);

            $info = pathinfo($filename);
            $info["dirname"] = $dirName[1];
            $info["size"] = filesize($filename);
            $info["modified"] = date("d/m/Y H:i:s", filemtime($filename));

            array_push($dirFiles, $info);
        }

        $arrayFiles = array();

        foreach ($dirFiles as $file) {
            array_push($arrayFiles, ["Name: " . $file["basename"], "Size: " . $file["size"] . "KByte", "Modified: " . $file["modified"], "Directory: " . $file["dirname"]]);
        }

        return $this->successResponse(['quantidade de conteúdos: ' . $qtdFiles, $arrayFiles], 'sucesso!', 200);
    }
}
