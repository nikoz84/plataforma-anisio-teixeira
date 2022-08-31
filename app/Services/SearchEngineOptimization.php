<?php

namespace App\Services;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Str;

class SearchEngineOptimization
{
    private const ROOT = "\\App\Models\\";

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function getMetadata()
    {
        $url = collect(explode('/', $this->request::path()));

        $contains_aplicativo = Str::containsAll(
            $this->request::path(),
            ['exibir', 'aplicativo',
            ]
        );
        $contains_conteudo = Str::containsAll(
            $this->request::path(),
            ['exibir', 'conteudo',
            ]
        );

        $slug = $url->first();
        $canal = \App\Models\Canal::where('slug', $slug)->get()->first();

        if ($contains_conteudo || $contains_aplicativo) {
            $id = intval($url->last());

            $intersect = $url->intersect(['aplicativo', 'conteudo']);
            $class_name = self::ROOT.Str::ucfirst($intersect->first());
            $data = $this->getFromClass($class_name, $id);
        } elseif ($canal && ! $contains_aplicativo && ! $contains_conteudo) {
            $data = $this->getCanalData($canal);
        } else {
            $data = $this->getDefaultData();
        }

        return $data;
    }

    public function getDefaultData()
    {
        return [
            'title' => Config::get('seo.title'),
            'author' => Config::get('seo.author'),
            'url' => $this->request::fullUrl(),
            'description' => Config::get('seo.description'),
            'keywords' => Config::get('seo.keywords'),
            'canonical' => Config::get('seo.canonical'),
            'locale' => Config::get('seo.locale'),
            'sitename' => Config::get('seo.sitename'),
        ];
    }

    public function getCanalData($canal)
    {
        return [
            'title' => $canal->name ?? '',
            'author' => Config::get('seo.author'),
            'url' => $this->request::fullUrl(),
            'description' => $canal->excerpt,
            'keywords' => "Canal {$canal->name}, Conteúdos Digitais, Recursos Educacionais, Licenças Livres",
            'canonical' => $this->request::fullUrl(),
            'locale' => Config::get('seo.locale'),
            'sitename' => Config::get('seo.sitename'),
        ];
    }

    public function getFromClass($class_name, $id)
    {
        if (class_exists($class_name)) {
            $class = $class_name::with(['tags'])->find($id);
            if (! $class) {
                return $this->getDefaultData();
            }

            $tags = $class->tags->implode('name', ', ');

            return [
                'title' => $class->title ? $class->title : $class->name,
                'author' => Config::get('seo.author'),
                'url' => $this->request::fullUrl(),
                'description' => $class->excerpt,
                'keywords' => "{$tags}",
                'canonical' => $this->request::fullUrl(),
                'locale' => Config::get('seo.locale'),
                'sitename' => Config::get('seo.sitename'),
                'image' => $class->image,
            ];
        }
    }
}
