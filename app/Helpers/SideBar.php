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
            case 5:
                return self::getSidebarSitesTematicos();
                break;
            case 6:
                return self::getSideBarAdvancedFilter();
                break;
            default:
                return self::getSideBarCategories($id);
                break;
        }
    }
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
    /** categorias dos canais */
    private static function getSideBarCategories($id)
    {
        $categorias = Category::selectRaw("id, parent_id, name, options->'is_active' as is_active")
            ->where('canal_id', $id)
            ->whereRaw('parent_id is null')
            ->where('options->is_active', 'true')
            ->with('subCategories')
            ->orderBy('created_at', 'asc')
            ->get();
        $disciplinas = NivelEnsino::where('id', '=', 5)->with('components')->get()->first();
        $aplicativosCat = AplicativoCategory::orderBy('name')->get(['id', 'name']);

        return [
            'categories' => $id == 9 ? $aplicativosCat : $categorias,
            'disciplinas' => $id == 2 ? $disciplinas : []
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
}
