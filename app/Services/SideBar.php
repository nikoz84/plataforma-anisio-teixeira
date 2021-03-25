<?php

namespace App\Services;

use App\Models\NivelEnsino;
use App\Models\CurricularComponentCategory;
use App\Models\License;
use App\Models\Tipo;
use App\Models\User;
use App\Models\Options;
use Illuminate\Support\Facades\DB;

class SideBar
{

    public static function getSideBarAdvancedFilter()
    {
        $componentes = CurricularComponentCategory::with(['componentes' => function ($q) {
            $q->orderBy('name');
        }])->get();

        $licencas = License::select(['id', 'name'])
        ->whereRaw('parent_id is null')->get();

        $niveis = NivelEnsino::with(['componentes'])
        ->where('id', '<>', 13)
        ->where('id', '<>', 12)
        ->get();

        $layout = (object) Options::select("meta_data")
        ->where("name", "like", "layout")->get()->first();
        $canais =  DB::select(DB::raw("SELECT name,
                                    slug,
                                    options->'order_menu' AS order,
                                    options->'back_url_exibir' AS url_exibir
                                    FROM canais
                                    WHERE is_active = ?
                                    ORDER BY options->'order_menu';"), [true]);
        
        return [
            'layout' => $layout,
            'links' => $canais,
            'licencas' => $licencas,
            'componentes' => $componentes,
            'niveis' => $niveis,
            'tipos' => Tipo::select(['id', 'name'])->orderBy('name')->get()
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
        $links = $this->getlinks();
        $linksArr = [];
        foreach ($links as $link) {
            if ($user->can('index', $link['class'])) {
                array_push(
                    $linksArr,
                    $this->createMenu(
                        $link['label'],
                        $link['name'],
                        $link['slug']
                    )
                );
            }
        }
        
        return (object) $linksArr;
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
    public function createMenu($label, $name, $slug)
    {

        return [
            "label" => $label,
            "name" => $name,
            "slug" => $slug
        ];
    }
    /**
     * Configurações de links
     *
     * @return array de configuração
     */
    public function getlinks()
    {
        return collect([
            [
                'label' => 'Aplicativos',
                'name' => 'IndexAplicativos',
                'slug' => 'aplicativos',
                'hability' => 'index',
                'class' => \App\Models\Aplicativo::class
            ],
            [
                'label' => 'Conteúdos',
                'name' => 'IndexConteudos',
                'slug' => 'conteudos',
                'hability' => 'index',
                'class' => \App\Models\Conteudo::class
            ],
            [
                'label' => 'Canais',
                'name' => 'IndexCanais',
                'slug' => 'canais',
                'hability' => 'index',
                'class' => \App\Models\Canal::class
            ],
            [
                'label' => 'Fale Conosco',
                'name' => 'IndexContatos',
                'slug' => 'contato',
                'hability' => 'index',
                'class' => \App\Models\Contato::class
            ],
            [
                'label' => 'Opções de sistema',
                'name' => 'IndexOptions',
                'slug' => 'options',
                'hability' => 'index',
                'class' => \App\Models\Options::class
            ],
            [
                'label' => 'Licenças',
                'name' => 'IndexLicencas',
                'slug' => 'licencas',
                'hability' => 'index',
                'class' => \App\Models\License::class
            ],
            [
                'label' => 'Tipo de Usuário',
                'name' => 'IndexRoles',
                'slug' => 'roles',
                'hability' => 'index',
                'class' => \App\Models\Role::class
            ],
            [
                'label' => 'Palavras-Chaves',
                'name' => 'IndexTags',
                'slug' => 'tags',
                'hability' => 'index',
                'class' => \App\Models\Tag::class
            ],
            [
                'label' => 'Tipos de Conteúdos',
                'name' => 'IndexTipos',
                'slug' => 'tipos',
                'hability' => 'index',
                'class' => \App\Models\Tipo::class
            ],
            [
                'label' => 'Usuários',
                'name' => 'IndexUsuarios',
                'slug' => 'usuarios',
                'hability' => 'index',
                'class' => \App\Models\User::class
            ],
            [
                'label' => 'Categorias',
                'name' => 'IndexCategorias',
                'slug' => 'categorias',
                'hability' => 'index',
                'class' => \App\Models\Category::class
            ],
            [
                'label' => 'Componentes Curriculares',
                'name' => 'IndexComponentes',
                'slug' => 'componentes',
                'hability' => 'index',
                'class' => \App\Models\CurricularComponent::class
            ],
            [
                'label' => 'Categorias dos Componentes Curriculares',
                'name' => 'IndexComponentesCategorias',
                'slug' => 'componentescategorias',
                'hability' => 'index',
                'class' => \App\Models\CurricularComponentCategory::class
            ],
            [
                'label' => 'Níveis de Ensino',
                'name' => 'IndexNiveisEnsino',
                'slug' => 'nivelensino',
                'hability' => 'index',
                'class' => \App\Models\NivelEnsino::class
            ],
            [
                'label' => 'Logs Laravel',
                'name' => 'IndexLogArtisanLaravel',
                'slug' => 'logartisan',
                'hability' => 'index',
                'class' => \App\LogArtisan::class
            ],
        ]);
    }
}
