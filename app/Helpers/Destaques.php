<?php

namespace App\Helpers;

use App\Conteudo;
use App\Aplicativo;

class Destaques
{
    // CONTEÙDOS
    public function getConteudosMaisRecentes()
    {
        $conteudos = Conteudo::orderBy('created_at', 'desc')
            ->limit(4)
            ->get();

        return $conteudos->map(function ($conteudo) {
            return $conteudo->only(['id', 'title', 'image', 'url_exibir']);
        });
    }

    public function getConteudosMaisBaixados()
    {
        $conteudos = Conteudo::orderBy('qt_downloads', 'desc')->limit(4)->get();

        return $conteudos->map(function ($conteudo) {
            return $conteudo->only(['id', 'title', 'image', 'qt_downloads', 'url_exibir']);
        });
    }
    public function getConteudosMaisAcessados()
    {
        $conteudos = Conteudo::orderBy('qt_access', 'desc')->limit(4)->get();

        return $conteudos->map(function ($conteudo) {
            return $conteudo->only(['id', 'title', 'image', 'qt_access', 'url_exibir']);
        });
    }

    public function getConteudosDestaques()
    {
        $conteudos = Conteudo::where("is_featured", true)->limit(4)->get();

        return $conteudos->map(function ($conteudo) {
            return $conteudo->only(['id', 'title', 'image', 'url_exibir']);
        });
    }
    // APLICATIVOS
    public function getAplicativosDestaques()
    {
        $aplicativos = Aplicativo::whereRaw("options->'is_featured' = 'true'")
            ->limit(4)->get();

        return $aplicativos->map(function ($aplicativo) {
            return $aplicativo->only(['id', 'name', 'image', 'url_exibir']);
        });
    }
    public function getAplicativosMaisRecentes()
    {
        $aplicativos = Aplicativo::orderBy('created_at', 'desc')->limit(4)->get();

        return $aplicativos->map(function ($aplicativo) {
            return $aplicativo->only(['id', 'name', 'image', 'url_exibir']);
        });
    }
}
