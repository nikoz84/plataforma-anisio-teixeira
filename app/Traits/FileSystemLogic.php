<?php

namespace App\Traits;

use DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Arr;

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
        } else {
            return Storage::disk('conteudos-digitais')->url("imagem-associada/tipo-conteudo/{$tipo}.png");
        }
    }
    //http://pat.des/storage/conteudos/conteudos-blog/uploads/2019/05/Estudos-595x459.png
    public function getBlogImage($media)
    {
        // $media[0]->media_details->sizes->{"featured-blog-medium"}->source_url;
        ///img/img-fundo-padrao.svg;
        //$media->media_details->sizes->medium

        $search_img = $media->media_details->sizes->medium->file;
        $file = $media->media_details->file;
        $path = explode('/', $file);
        array_pop($path);
        $path = implode('/', $path) . '/' . $search_img;
        die($path);
        if ((Storage::disk('conteudos-blog')->exists($path))) {
            return Storage::disk('conteudos-blog')->url($path);
        } else {
            return '/img/img-fundo-padrao.svg';
        }
    }
}
