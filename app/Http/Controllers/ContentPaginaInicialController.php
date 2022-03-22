<?php

namespace App\Http\Controllers;

use App\Models\ContentPaginaInicial;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class ContentPaginaInicialController extends ApiController
{



    public function __construct(Request $request, ContentPaginaInicial $contentPaginaInicial)
    {
        $this->contentPaginaInicial = $contentPaginaInicial;
        $this->request = $request;

        $this->middleware('auth:api')->except([
            'create', 'getConteudo'

        ]);
    }


    /**
     * Adiciona ou Atualizada o conteúdo da página inicial
     *
     * @return string json
     */
    public function create()
    {
        $conteudo = $this->request->conteudo;


        $update_conteudo = DB::table('content_pagina_inicial')
            ->where('id', 1)
            ->update(['conteudo' => $conteudo]);

        return $this->successResponse([], 'Conteúdo Atualizado com sucesso!', 200);
    }

    /**
     * pegar o conteúdo da página inicial
     *
     * @
     * @return void
     */
    public function getConteudo()
    {
        $conteudos = DB::table('content_pagina_inicial')->select('conteudo')->get();
        //print_r($conteudos);
        //die();

        return $conteudos;
    }
}
