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
        $this->middleware('jwt.auth')->except(['index', 'search', 'getFiles', 'getGallery', 'downloadFile', 'getInfoFolder', 'fileExistInBase']);
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

    /**
     * Função responsável por exibir informações de um diretório passado por parametro.
     */
    public function getInfoFolder(Request $request)
    {
        if ($request->path == 'public') {
            $path = storage_path('app' . DIRECTORY_SEPARATOR . $request->path);
        } else {
            $path = storage_path('app' . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . $request->path);
        }
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

    /**
     * Função responsável por verificar na base de dados se
     * existe arquivos de um diretório passado por parametro.
     */
    public function fileExistInBase(Request $request)
    {
        $path = storage_path('app' . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . $request->path);

        $files = scandir($path);

        $arrayExist = array();
        $arrayNotExist = array();

        foreach ($files as $file) {
            if (($file == '.') || ($file == '..')) continue;

            $dirFile = $path . DIRECTORY_SEPARATOR . $file;

            if (!is_dir($dirFile)) {
                $info = pathinfo($dirFile);

                $fileName = explode('.', $info["filename"]);

                if (Conteudo::where('id', $fileName[0])->count() > 0) {
                    array_push($arrayExist, $info["basename"] . ' Existe na base de dados');
                } else {
                    array_push($arrayNotExist, $info["basename"] . ' Nao existe na base de dados');
                }
            }
        }

        return $this->successResponse(['Existe' => $arrayExist, 'Nao existe' => $arrayNotExist], 'sucesso!', 200);
    }
}
