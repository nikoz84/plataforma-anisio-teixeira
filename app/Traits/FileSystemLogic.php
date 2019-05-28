<?php

namespace App\Traits;

use DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Filesystem\Filesystem;

trait FileSystemLogic
{
    // conteudos/conteudos-digitais/imagem-associada/emitec/img-emitec_disciplina29.png
    public static function getEmitecImage($components)
    {
        $disciplina = DB::table('curricular_components as cc')
            ->select(["cc.id"])
            ->join('niveis_ensino as ne', 'ne.id', '=', 'cc.nivel_id')
            ->whereIn('cc.id', $components)
            ->get()
            ->first();
        $image = "/imagem-associada/emitec/img-emitec_disciplina{$disciplina->id}.png";
        $exist = Storage::disk('conteudos-digitais')->exists($image);

        return ($exist) ? Storage::disk('conteudos-digitais')->url($image) : null;
    }

    // conteudos/conteudos-digitais/imagem-associada/sinopse/9903.01.jpg
    // conteudos/conteudos-digitais/imagem-associada/9721.jpg
    public static function getImageFromTipo($tipo, $id)
    {
        $path_assoc = Storage::disk('conteudos-digitais')->path("imagem-associada");


        $filesystem = new Filesystem;
        $files = [];

        $file = ($tipo == 5) ? $path_assoc . "/sinopse/{$id}.*.*" : $path_assoc . "/{$id}.*";

        $files = $filesystem->glob($file);

        if (count($files)) {
            $image = $files[array_rand($files)];
            if ($filesystem->exists($image)) {
                $replace_full_path = str_replace($path_assoc, "", $image);
                return Storage::disk('conteudos-digitais')->url("imagem-associada" . $replace_full_path);
            }
        }




        //$exist = Storage::disk('conteudos-digitais')->exists($image);

        //return array_rand($files, 1);

    }
}
