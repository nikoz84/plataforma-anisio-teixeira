<?php

namespace App\Helpers;

use App\Category;
use App\AplicativoCategory;
use App\NivelEnsino;
use App\CurricularComponentCategory;
use App\License;
use App\Tipo;

class SideBar
{

    public static function getSideBar($id)
    {
        switch ($id) {
            case 1:
            case 2:
            case 3:
            case 12:
                return self::getSideBarCategories($id);
                break;
            case 7:
                return [];
                break;
            case 5:
                return self::getSidebarSitesTematicos();
                break;
            case 6:
                return self::getSideBarAdvancedFilter();
                break;
            case 9:
                return ['categories' => AplicativoCategory::get()];
                break;
            case 'admin':
                return;
                break;
            case 'home':
                return;
                break;
        }
    }
    private static function getSideBarAdvancedFilter()
    {
        $componentes = CurricularComponentCategory::with('components')->get()->first();
        $tipos = Tipo::select(['id', 'name'])->get();
        $licencas = License::select(['id', 'name'])->whereRaw('parent_id is null')->get();
        $niveis = NivelEnsino::with('components')->get()->first();

        return [
            'tipos' => $tipos,
            'licenses' => $licencas,
            'components' => $componentes,
            'niveis' => $niveis[0]
        ];
    }

    private static function getSideBarCategories($id)
    {
        /** categorias dos canais */
        $categories = Category::selectRaw("id, parent_id, name, options->'is_active' as is_active")
            ->where('canal_id', $id)
            ->whereRaw('parent_id is null')
            ->where('options->is_active', 'true')
            ->with('subCategories')
            ->orderBy('created_at', 'asc')
            ->get();
        /** disciplinas ensino medio */
        $disciplinas = [];
        if ($id == 2) {
            $disciplinas = NivelEnsino::where('id', '=', 5)->with('components')->get()->first();
            return [
                'categories' => $categories,
                'disciplinas' => $disciplinas
            ];
        }

        return ['categories' => $categories];
    }
    private static function getSidebarSitesTematicos()
    {
        $temas = CurricularComponentCategory::where('id', '=', 3)->with('components')->get()->first();
        $disciplinas = NivelEnsino::where('id', '=', 5)->with('components')->get()->first();

        return [
            "temas" => $temas,
            "disciplinas" => $disciplinas
        ];
    }
}
