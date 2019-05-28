<?php

namespace App\Traits;

use DB;
use Illuminate\Support\Facades\Storage;

trait FileSystemLogic
{
    public static function getEmitecImage($components){
        $disciplina = DB::table('curricular_components as cc')
                            ->select(["cc.id"])
                            ->join('niveis_ensino as ne','ne.id', '=', 'cc.nivel_id')
                            ->whereIn('cc.id', $components)
                            ->get()
                            ->first();
        $image = "/imagem-associada/emitec/img-emitec_disciplina{$disciplina->id}.png";                            
        $exist = Storage::disk('conteudos-digitais')->exists($image);

        return ($exist) ? Storage::disk('conteudos-digitais')->url($image) : null;  
    }
}
