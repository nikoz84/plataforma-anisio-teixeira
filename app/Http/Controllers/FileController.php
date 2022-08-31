<?php

namespace App\Http\Controllers;

use App\Helpers\ContentVideoConvert;
use App\Jobs\VideoStreamingConvert;
use App\Models\Conteudo;
use App\Traits\FileSystemLogic;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Streaming\FFMpeg;

class FileController extends ApiController
{
    use FileSystemLogic;

    private $_imagick;

    public function __construct(File $file, Request $request, Storage $storage)
    {
        $this->middleware('jwt.auth')->except([
            'index', 'search', 'getFiles', 'getGallery', 'downloadFile', 'getInfoFolder', 'fileExistInBase',
            'ffmpegTeste', 'showVideoStreaming',
        ]);
        $this->file = $file;
        $this->request = $request;
        $this->storage = $storage;
    }

    /**
     * Seleciona os arquivos por id.
     */
    public function getFiles($id)
    {
        $exists = Storage::disk('public')->exists('logo.png');

        return response(['exist' => $exists], 200, ['Content-Type' => 'image/png']);
    }

    /**
     *Função Cria o arquivo no Banco de dados usando id.
     *
     * @param [type] $id
     * @return void
     */
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
                'file' => $path,
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Erro no envio do arquivo',
        ]);
    }

    /**
     * Função Recursos anihados por rotas.
     */
    public function store()
    {
        if ($this->request->hasFile('imagem')) {
            $this->request->file('imagem');
        }
    }

    /**
     * Função que executa Download de arquivos no banco de dados.
     *
     * @param [type] $directory
     * @param  int  $id
     * @return void
     */
    public function downloadFile($directory, $id)
    {
        $conteudo = Conteudo::find($id);
        $conteudo->increment('qt_downloads');
        $conteudo->save();
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
            'Content-Type' => "$file->mime_type",
        ];

        $path = Storage::disk('conteudos-digitais')->path("{$directory}".DIRECTORY_SEPARATOR."{$file->name}");

        return response()->download($path, $file->name, $headers);
    }

    /**
     * Função que Requisita informações da Galeria
     *
     * @return string json
     */
    public function getGallery()
    {
        $imagens = collect($this->getImagesGallery(true));

        return $this->showAll($imagens);
    }

    /**
     * Função responsável por exibir informações de um diretório passado por parametro.
     *
     * @param Illuminate\Http\Request
     * @param Illuminate\Http\Request\$request
     * @return string json
     */
    public function getInfoFolder(Request $request)
    {
        if ($request->path == 'public') {
            $path = storage_path('app'.DIRECTORY_SEPARATOR.$request->path);
        } else {
            $path = storage_path('app'.DIRECTORY_SEPARATOR.'public'.DIRECTORY_SEPARATOR.$request->path);
        }
        $files = scandir($path);

        $qtdFiles = count($files) - 2;

        $dirFiles = [];

        foreach ($files as $file) {
            if (($file == '.') || ($file == '..')) {
                continue;
            }

            $filename = $path.DIRECTORY_SEPARATOR.$file;
            $dirName = explode('\public', $filename);

            $info = pathinfo($filename);
            $info['dirname'] = $dirName[1];
            $info['size'] = filesize($filename);
            $info['modified'] = date('d/m/Y H:i:s', filemtime($filename));

            array_push($dirFiles, $info);
        }

        $arrayFiles = [];

        foreach ($dirFiles as $file) {
            array_push($arrayFiles, ['Name: '.$file['basename'], 'Size: '.$file['size'].'KByte', 'Modified: '.$file['modified'], 'Directory: '.$file['dirname']]);
        }

        return $this->successResponse(['quantidade de conteúdos: '.$qtdFiles, $arrayFiles], 'sucesso!', 200);
    }

    /**
     * Existe Arquivos na base
     *
     * @param Illuminate\Http\Request
     * @param $request
     * @return string json
     */
    public function fileExistInBase(Request $request)
    {
        $path = storage_path('app'.DIRECTORY_SEPARATOR.'public'.DIRECTORY_SEPARATOR.$request->path);

        $files = scandir($path);

        $arrayExist = [];
        $arrayNotExist = [];

        foreach ($files as $file) {
            if (($file == '.') || ($file == '..')) {
                continue;
            }

            $dirFile = $path.DIRECTORY_SEPARATOR.$file;

            if (! is_dir($dirFile)) {
                $info = pathinfo($dirFile);

                $fileName = explode('.', $info['filename']);

                if (Conteudo::where('id', $fileName[0])->count() > 0) {
                    array_push($arrayExist, $info['basename'].' Existe na base de dados');
                } else {
                    array_push($arrayNotExist, $info['basename'].' Nao existe na base de dados');
                }
            }
        }

        return $this->successResponse(['Existe' => $arrayExist, 'Nao existe' => $arrayNotExist], 'sucesso!', 200);
    }

    /**
     * Convert PDF to image JPG
     *
     * @param  string  $filePath
     * @param  string  $customPath
     * @return void
     */
    public function convertPdfToImage(Request $request)
    {
        if (! extension_loaded('imagick')) {
            return response()->json(['Extensao Imagick Nao está habilitada para uso!']);
        }

        $extension = 'jpg';

        $file = $request->file('file');

        $filePath = storage_path('app'.DIRECTORY_SEPARATOR.'public'.DIRECTORY_SEPARATOR.'conteudos'.DIRECTORY_SEPARATOR.'conteudos-digitais'.DIRECTORY_SEPARATOR.'pdf-imagens'.DIRECTORY_SEPARATOR.$file->getClientOriginalName());

        if (! file_exists($filePath)) {
            $filePath = $this->storeFile($request);
        }

        $_imagick = new \Imagick(str_replace('\\', '/', $filePath));

        $noOfPagesInPDF = $_imagick->getNumberImages();

        // if ($noOfPagesInPDF) {
        //     for ($i = 0; $i < $noOfPagesInPDF; $i++) {

        $fileNameWithoutExtension = $this->_getFileName($filePath, $this->_getFileExtension($filePath));

        $filePath = $this->_getFileDirectory($filePath);

        $newFile = $filePath.DIRECTORY_SEPARATOR.$fileNameWithoutExtension.'.'.$extension;

        $_imagick->setImageFormat($extension);

        $_imagick->writeImage($newFile);
        //     }
        // }

        if (file_exists($newFile)) {
            return $this->successResponse([$fileNameWithoutExtension.'.'.$extension], 'Arquivo convertido para imagem com sucesso!', 200);
        } else {
            return $this->successResponse([], 'Houve algum erro ao tentar fazer a conversão!', 200);
        }
    }

    /**
     * Return file name with extension or without extension
     *
     * @param  string  $filePath
     * @param  string  $extension - Extension to be removed from file name
     * @return string
     */
    private function _getFileName($filePath, $extension = null)
    {
        if ($extension == null) {
            $name = basename($filePath);

            return $name;
        } else {
            $name = basename($filePath, $extension);

            return $name;
        }
    }

    /**
     * Return file extension from file path
     *
     * @param  string  $filePath
     * @return string
     */
    private function _getFileExtension($filePath)
    {
        $extension = pathinfo($filePath, PATHINFO_EXTENSION);

        return '.'.$extension;
    }

    /**
     * Return path from file path
     *
     * @param  string  $filePath
     * @return string
     */
    private function _getFileDirectory($filePath)
    {
        $extension = pathinfo($filePath, PATHINFO_DIRNAME);

        return $extension;
    }

    /**
     * Histórico de arquivos
     *
     * @param  mixed  $request
     * @return null|string path
     */
    private function storeFile($request)
    {
        $path = null;

        if ($request->hasFile('file') && $request->file('file')->isValid()) {
            $fileName = $request->file->getClientOriginalName();

            $path = $request->file->storeAs('conteudo-digitais'.DIRECTORY_SEPARATOR.'pdf-imagens', $fileName);

            $path = storage_path('app'.DIRECTORY_SEPARATOR.'public'.DIRECTORY_SEPARATOR.$path);
        }

        return $path ? $path : $this->errorResponse([], 'Falha ao fazer upload!', 500);
    }

    /**
     *  Teste de ffmpeg
     *
     * @param Id Identificador único $id
     * @return void
     */
    public function ffmpegTeste($id)
    {
        try {
            $root = Storage::disk('conteudos-digitais')->path('streaming');
            $contentVideoConvert = new ContentVideoConvert(Conteudo::findOrFail($id), FFMpeg::create(config('ffmpeg')));
            VideoStreamingConvert::dispatch($contentVideoConvert, $root);
            //$contentVideoConvert->convertToStreaming($root, FFMpeg::create(config('ffmpeg')));
        } catch (Exception $ex) {
            return $ex;
        }
    }

    /**
     * Video Streaming
     *
     * @param  int Id  identificador único $id
     * @return void
     */
    public function showVideoStreaming($id)
    {
        try {
            $conteudo = Conteudo::findOrFail($id);
            $file = $conteudo->streamingFileConteudo($id);

            return view('streaming.video', compact('file'));
        } catch (Exception $e) {
            return $e;
        }
    }

    /**
     * Deleta o arquivo
     *
     * @param  Illuminate\Http\Request  $request
     * @return App\Traits\ApiResponser::errorResponse
     */
    public function deleteFile(Request $request)
    {
        $filename = $request->filename;
        $directory = $request->directory;
        $role = Auth::user()->role->name;
        if (Auth::check() && $role == 'super-admin' || $role == 'admin' || $role == 'coordenador') {
            $file = Storage::disk($directory)->path($filename);
            if (file_exists($file)) {
                $response = unlink($file) ? 'Apagado com sucesso' : 'Não encontrado';

                return $this->successResponse([
                    'success' => true,
                ], $response, 200);
            }
        }

        return $this->errorResponse(['success' => false], 'Usuário sem permissões para realizar esta ação', 422);
    }
}
