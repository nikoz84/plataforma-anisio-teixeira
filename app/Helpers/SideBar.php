<?php

namespace App\Helpers;

use App\NivelEnsino;
use App\CurricularComponentCategory;
use App\License;
use App\Tipo;
use App\User;

class SideBar
{

    private static function getSideBarAdvancedFilter()
    {
        $componentes = CurricularComponentCategory::with(['components' => function ($q) {
            $q->orderBy('name');
        }])->get();
        $tipos = Tipo::select(['id', 'name'])->get();
        $licencas = License::select(['id', 'name'])->whereRaw('parent_id is null')->get();
        $niveis = NivelEnsino::with(['components' => function ($q) {
            $q->where('curricular_components.id', '!=', 13)
                ->where('curricular_components.id', '!=', 12)
                ->orderBy('name');
        }])->get();

        return [
            'tipos' => $tipos,
            'licenses' => $licencas,
            'components' => $componentes,
            'niveis' => $niveis
        ];
    }


    /**categorias dos sites tematicos */
    private static function getSidebarSitesTematicos()
    {
        $temas = CurricularComponentCategory::where('id', '=', 3)->with('components')->get()->first();
        $disciplinas = NivelEnsino::where('id', '=', 5)->with('components')->get()->first();

        return [
            'temas' => $temas,
            "disciplinas" => $disciplinas
        ];
    }
    /**
     * Cria o menu de administração
     *
     * @param User $user
     * @return void
     */
    public function getAdminSidebar(User $user)
    {
        $linksLabels = $this->linksLabels();
        $links = [];

        $links = $linksLabels->map(function ($link) use ($user) {
            if ($user->can($link['hability'], $link['class'])) {
                return $this->createArray($link['label'], $link['slug']);
            }
        });

        return $links;
    }
    /**
     * Cria json para Links de administração
     *
     * @param [type] $label
     * @param [type] $slug
     * @param string $name
     * @param string $view
     * @param string $action
     * @return void
     */
    public function createArray($label, $slug, $name = '', $view = 'admin', $action = 'listar')
    {

        return [
            "label" => $label,
            "name" => $name ? $name : $slug,
            "view" => $view,
            "params" => ["slug" => $slug, "action" => $action]
        ];
    }
    /**
     * Configurações de links
     *
     * @return void
     */
    public function linksLabels()
    {
        return collect([
            [
                'label' => 'Aplicativos',
                'slug' => 'aplicativos',
                'hability' => 'index',
                'class' => \App\Aplicativo::class
            ],
            [
                'label' => 'Conteudos',
                'slug' => 'conteudos',
                'hability' => 'index',
                'class' => \App\Conteudo::class
            ],
            [
                'label' => 'Canais',
                'slug' => 'canais',
                'hability' => 'index',
                'class' => \App\Canal::class
            ],
            [
                'label' => 'Denúncias',
                'slug' => 'denuncias',
                'hability' => 'index',
                'class' => \App\Denuncia::class
            ],
            [
                'label' => 'Licenças',
                'slug' => 'licencas',
                'hability' => 'index',
                'class' => \App\License::class
            ],
            [
                'label' => 'Tipo de Usuário',
                'slug' => 'roles',
                'hability' => 'index',
                'class' => \App\Role::class
            ],
            [
                'label' => 'Palavras Chaves',
                'slug' => 'tags',
                'hability' => 'index',
                'class' => \App\Tag::class
            ],
            [
                'label' => 'Tipos de Conteúdos',
                'slug' => 'tipos',
                'hability' => 'index',
                'class' => \App\Tipo::class
            ],
            [
                'label' => 'Usuários',
                'slug' => 'usuarios',
                'hability' => 'index',
                'class' => \App\User::class
            ]
        ]);
    }
}
