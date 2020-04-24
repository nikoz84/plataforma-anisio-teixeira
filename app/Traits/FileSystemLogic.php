<?php

namespace App\Traits;

use Illuminate\Support\Facades\DB;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

trait FileSystemLogic
{
    /**
     * Retorna imagem de destaque do nivel de ensino
     * 
     * @param $components array de componentes curriculares
     * 
     * 
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

        $image = "/imagem-associada/emitec/img-emitec_disciplina{$disciplina->id}.png";
        $exist = Storage::disk('conteudos-digitais')->exists($image);

        return ($exist) ? Storage::disk('conteudos-digitais')->url($image) : null;
    }

    /**
     * Retorna imagem de destque
     *
     * @param $tipo tipo de conteúdo
     *
     * @param $id ID do conteúdo
     *
     * @return Storage
     */
    public static function getImageFromTipo($tipo, $id)
    {
        $path_assoc = Storage::disk('conteudos-digitais')->path("imagem-associada");

        $filesystem = new Filesystem;
        $files = [];
        $img_assoc = $path_assoc . "/{$id}.*";
        $file = $filesystem->glob($img_assoc);
        $img_sinopse = $path_assoc . "/sinopse/{$id}.*.*";
        $files = $filesystem->glob($img_sinopse);

        if (count($file) > 0) {
            $img_assoc = array_values($file)[0];
            $img_assoc = str_replace($path_assoc, "", $img_assoc);
            return Storage::disk('conteudos-digitais')->url("imagem-associada" . $img_assoc);
        } elseif ($tipo == 5 && count($files) > 0) {
            $index = array_rand($files);
            $img_sinopse = $files[$index];
            $img_sinopse = str_replace($path_assoc, "", $img_sinopse);
            return Storage::disk('conteudos-digitais')->url("imagem-associada" . $img_sinopse);
        }

        return Storage::disk('public-path')->url("img/fundo-padrao.svg");
    }
    /**
     * Retorna galeria de imagens
     *
     * @param $rand seleciona se ordena de forma randomica as imagens
     *
     * @return Storage
     */
    public function getImagesGallery($rand = false)
    {
        $path = $this->storage::disk('galeria');
        $files = File::allFiles($path);

        if (!$rand) {
            return collect($files)->map(function ($file) {
                return Storage::disk('galeria')->url("{$file->getFilename()}");
            });
        }

        return collect($files)->map(function ($file) {
            return Storage::disk('galeria')->url("{$file->getFilename()}");
        })->inRandomOrder()->first();
    }
    /**
     * Salva arquivo pasta de downloads
     *
     * @param $id integer
     * @param $file laravel request
     *
     * @return File
     */
    public function createFile($id, $file)
    {
        if ($file) {
            $filesystem = new Filesystem;
            $path = Storage::disk('conteudos-digitais')->path("download") . "/{$id}.*";
            $files = $filesystem->glob($path);
            File::delete($files);
            $name = "{$id}.{$file->guessExtension()}";
            
            $file->storeAs('download', $name, 'conteudos-digitais');
            return $file;
        }
    }
    /**
     * Remplaza diretorio de windows C:\\pasta\pasta-filha por C://pasta/pasta-filha
     *
     * @param $path diretorio
     *
     * @return string
     */
    public function windowsDirectory($path)
    {
        if (env('APP_SO', 'linux') == 'windows') {
            return str_replace('\\', '/', $path);
        }

        return $path;
    }
}
