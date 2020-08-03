<?php

namespace App\Traits;

use Illuminate\Support\Facades\DB;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Helpers\ReplaceStr;

trait FileSystemLogic
{
    /**
     * Retorna imagem de destaque do nivel de ensino
     *
     * @param $components array de componentes curriculares
     *
     * @return string
     */
    public static function getEmitecImage($components)
    {
        $arrComp = $components->get()->pluck('id')->toArray();
        $disciplina = DB::table('curricular_components as cc')
            ->select(["cc.id"])
            ->join('niveis_ensino as ne', 'ne.id', '=', 'cc.nivel_id')
            ->whereIn('cc.id', $arrComp)
            ->get()
            ->first();
        if (!$disciplina) {
            return Storage::disk('public-path')->url("img/fundo-padrao.svg");
        }
        $image = DIRECTORY_SEPARATOR."imagem-associada". DIRECTORY_SEPARATOR ."emitec". DIRECTORY_SEPARATOR ."img-emitec_disciplina{$disciplina->id}.png";
        $exist = self::windowsDirectory(Storage::disk('conteudos-digitais')->exists($image));
        return ($exist) ? Storage::disk('conteudos-digitais')->url($image) : null;
    }

    public static function getCategoryImage($category_id)
    {
        $path_category =  Storage::disk('conteudos-digitais')->path("imagem-associada". DIRECTORY_SEPARATOR ."categorias". DIRECTORY_SEPARATOR ."{$category_id}.*");
        $file = collect(File::glob($path_category))->first();
        if ($file) {
            $filename = basename($file);
            return  Storage::disk('conteudos-digitais')->url("imagem-associada/categorias/{$filename}");
        }
        return null;
    }

    /**
     * Retorna imagem de destaque
     * @param $tipo tipo de conteúdo
     * @param $id id do conteúdo
     * @return Storage
     */
    public static function getImageFromTipo($tipo, $id)
    {
        $path = Storage::disk('conteudos-digitais')->path("imagem-associada");
        if ($tipo->id == 5) 
        {
            $path_sinopse = "{$path}". DIRECTORY_SEPARATOR ."sinopse". DIRECTORY_SEPARATOR."$id.*";
            $file = collect(File::glob($path_sinopse))->shuffle()->first();
            if($file)
            return Storage::disk('conteudos-digitais')->url("imagem-associada/sinopse/".basename($file));
        }
        else
        {
            $iconeNome = ReplaceStr::replace($tipo->name);
            $file = Storage::disk('public-path')->url("img/tipo-conteudo/".strtolower($iconeNome).".svg");
        }
        return $file;

    }

    public static function getImageFromConteudo($id)
    {
        $path_assoc = Storage::disk('conteudos-digitais')->path('imagem-associada');
        $file = self::findFiles($path_assoc, $id);
        if($file)
        {
            return Storage::disk('conteudos-digitais')->url("imagem-associada/".basename($file));
        }
        return $file;
    }
    /**
     * Procura no diretorio os arquivos de imagem associada ou sinopse
     * @param $path     diretorio
     * @param $filename nome do arquivo a ser encontrado
     * @param $tipo     id do tipo de conteúdo
     * @return string
     */
    public static function findFiles($path, $id)
    {
        $path_img_assoc = "{$path}". DIRECTORY_SEPARATOR ."$id.*";
        $file = collect(File::glob($path_img_assoc))->last();
        return Str::replaceFirst($path . '/', '', $file);
    }

    public static function getAplicativoImage($id)
    {
        $image = Storage::disk('aplicativos-educacionais')->path("imagem-associada"). DIRECTORY_SEPARATOR . "{$id}.*";
        $file = collect(File::glob($image))->first();
        $filename = basename($file);
       
        return $filename ? Storage::disk('aplicativos-educacionais')->url("imagem-associada/{$filename}") : null;
        
    }
    /**
     * Seleciona os metadados do arquivo
     *
     * @param $directory diretorio a procurar
     * @param $id        id do conteudo
     *
     * @return array
     */
    public function getMetaDados($directory, $id)
    {
        $filesystem = new Filesystem;

        $path = self::windowsDirectory(
            Storage::disk('conteudos-digitais')->path($directory) . "/{$id}.*"
        );

        $files = $filesystem->glob($path);
        $arr = [];
        foreach ($files as $file) {
            $name = $filesystem->name($file) . "." . $filesystem->extension($file);
            $arr = [
                'mime_type' => $filesystem->mimeType($file),
                'extension' => $filesystem->extension($file),
                'size'      => $filesystem->size($file),
                'name'      => $name,
                'url'       => Storage::disk('conteudos-digitais')->url($directory) . "/{$name}"
            ];
        }
        return (object) $arr;
    }

    /**
     * Retorna galeria de imagens
     * @param $rand seleciona se ordena de forma randomica as imagens
     * @return array de imagens
     */
    public function getImagesGallery($rand = false)
    {
        $path = $this->storage::disk('galeria');
        $path = self::windowsDirectory(
            $path->getDriver()->getAdapter()->getPathPrefix()
        );
        $files = File::allFiles($path);

        if (!$rand) {
            return collect($files)->map(function ($file) {
                return Storage::disk('galeria')->url("{$file->getFilename()}");
            });
        }
        return collect($files)->map(function ($file) {
            return Storage::disk('galeria')->url("{$file->getFilename()}");
        })->shuffle();
    }

    /**
     * Salva arquivo pasta de downloads
     * @param $id integer
     * @param $file laravel request
     * @return File
     */
    public function createFile($id, $file)
    {
        if ($file) {
            $filesystem = new Filesystem;
            $path = Storage::disk('conteudos-digitais')->path("download") . DIRECTORY_SEPARATOR ."{$id}.*";
            $files = $filesystem->glob($path);
            File::delete($files);
            $name = "{$id}.{$file->guessExtension()}";
            $file->storeAs('download', $name, 'conteudos-digitais');
            return $file;
        }
    }

    public function downloadFileConteudo($id)
    {
        $urlPath = Storage::disk('conteudos-digitais')->path("download");
        $urlPath = $urlPath.DIRECTORY_SEPARATOR.$this->id.".*";
        $file = collect(File::glob($urlPath))->first();
        $filename = basename($file);
        return $filename ? Storage::disk('conteudos-digitais')->url("download/{$filename}") : null;
    }

    public function guiaPedagogicoFileConteudo($id)
    {
        $urlPath = Storage::disk('conteudos-digitais')->path("guias-pedagogicos");
        $urlPath = $urlPath.DIRECTORY_SEPARATOR.$this->id.".*";
        $file = collect(File::glob($urlPath))->first();
        $filename = basename($file);
        return $filename ? Storage::disk('conteudos-digitais')->url("guias-pedagogicos/{$filename}") : null;
    }

    /**
     * Remplaza diretorio de windows C:\\pasta\pasta-filha por C:/pasta/pasta-filha
     * @param $path diretorio
     * @return string
     */
    public static function windowsDirectory($path)
    {
        if (env('APP_SO', 'linux') == 'windows') {
            return str_replace('\\', '/', $path);
        }
        return $path;
    }

    /**
     * Armazena arquivo pasta de guias-pedagogicos ou download ou imagem-associada
     * @param $id integer
     * @param $file laravel request
     * @return File
     */
    public function saveFile($id, $files,  $local = null, $disk="conteudos-digitais")
    {
        $file = null;
        if ($files) {
            foreach ($files as $file) {
                $filesystem = new Filesystem;
                $rand = rand(5, 99999);
                $path = Storage::disk($disk)->path($local) .DIRECTORY_SEPARATOR. "{$id}.*";
                $files = $filesystem->glob($path);
                $name = "{$id}.{$rand}.{$file->guessExtension()}";
                $file->storeAs($local, $name, $disk);
            }
            return $file;
        }
    }

    /**
     * Retorna tipos de extessões 
     *@return string $mimes
     */
    public function mimeTypes()
    {
        $mimes  = "ppt,pps,odp,link,pdf,epub,doc,docx,odt,swf,exe,zip,rar,swf,wmv,mpg,flv,";
        $mimes .= "avi,youtube,mp4,mp3,webm,xls,xlsx,xml,ods,csv,jpg,jpeg,png,gif,txt,csv";
        return $mimes;
    }
}