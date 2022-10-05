<?php

namespace App\Services;

use App\Models\Aplicativo;
use App\Models\Conteudo;

class Destaques
{
    public $limit = 6;

    public function __construct($limit = 6)
    {
        $this->limit = $limit;
    }

    /**
     * Retorna por demanda requisição
     *
     * @param [type] $slug
     * @return void
     */
    public function getHomeDestaques($slug)
    {
        switch ($slug) {
            case 'conteudos-recentes':
                return $this->getConteudosMaisRecentes();
                break;
            case 'conteudos-mais-baixados':
                return $this->getConteudosMaisBaixados();
                break;
            case 'conteudos-mais-acessados':
                return $this->getConteudosMaisAcessados();
                break;
            case 'conteudos-destacados':
                return $this->getConteudosDestaques();
                break;
            case 'aplicativos-destacados':
                return $this->getAplicativosDestaques();
                break;
            case 'aplicativos-recentes':
                return $this->getAplicativosMaisRecentes();
                break;
            default:
                return [];
                break;
        }
    }

    /**
     * Conteúdos mais recentes
     *
     * @return void
     */
    private function getConteudosMaisRecentes()
    {
        $conteudos = Conteudo::with(['tipo'])
            ->orderBy('created_at', 'desc')
            ->limit($this->limit)
            ->get();

        return [
            'title' => 'Conteúdos Recentes',
            'slug' => 'conteudos-recentes',
            'items' => $conteudos,
        ];
    }

    /**
     * Conteúdos mais baixados
     *
     * @return void
     */
    private function getConteudosMaisBaixados()
    {
        $conteudos = Conteudo::orderBy('qt_downloads', 'desc')->limit($this->limit)->get();

        return [
            'title' => 'Conteúdos Mais Baixados',
            'slug' => 'conteudos-mais-baixados',
            'items' => $conteudos->map(function ($conteudo) {
                return $conteudo->only(['id', 'title', 'image', 'qt_downloads', 'url_exibir']);
            }),
        ];
    }

    /**
     * Conteúdos mais acessados
     *
     * @return void
     */
    private function getConteudosMaisAcessados()
    {
        $conteudos = Conteudo::orderBy('qt_access', 'desc')->limit($this->limit)->get();

        return [
            'title' => 'Conteúdos Mais Acessados',
            'slug' => 'conteudos-mais-acessados',
            'items' => $conteudos->map(function ($conteudo) {
                return $conteudo->only(['id', 'title', 'image', 'qt_access', 'url_exibir']);
            }),
        ];
    }

    /**
     * Conteúdos destacados
     *
     * @return void
     */
    private function getConteudosDestaques()
    {
        $conteudos = Conteudo::where('is_featured', true)->limit($this->limit)->get();

        return [
            'title' => 'Conteúdos Destacados',
            'slug' => 'conteudos-destacados',
            'items' => $conteudos->map(function ($conteudo) {
                return $conteudo->only(['id', 'title', 'image', 'url_exibir']);
            }),
        ];
    }

    /**
     * aplicativos em destaque
     *
     * @return void
     */
    private function getAplicativosDestaques()
    {
        $aplicativos = Aplicativo::whereRaw("options->'is_featured' = 'true'")
            ->limit($this->limit)->get();

        return [
            'title' => 'Aplicativos Destacados',
            'slug' => 'aplicativos-destacados',
            'items' => $aplicativos->map(function ($aplicativo) {
                return $aplicativo->only(['id', 'name', 'image', 'url_exibir']);
            }),
        ];
    }

    /**
     * Aplicativos mais recentes
     *
     * @return void
     */
    private function getAplicativosMaisRecentes()
    {
        $aplicativos = Aplicativo::orderBy('created_at', 'desc')->limit($this->limit)->get();

        return [
            'title' => 'Aplicativos Recentes',
            'slug' => 'aplicativos-recentes',
            'items' => $aplicativos->map(function ($aplicativo) {
                return $aplicativo->only(['id', 'name', 'image', 'url_exibir']);
            }),
        ];
    }

    /**
     * Postagens recentes
     *
     * @return void
     */
    private function getPostsMaisRecentes()
    {
        //$wordpress = new WordpressService($this->request);
    }
}