<?php

namespace App\Http\Controllers;

use App\Canal;
use App\Category;
use App\AplicativoCategory;
use App\NivelEnsino;
use App\CurricularComponentCategory;
use App\License;
use App\Tipo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\ApiController;

class CanalController extends ApiController
{
    public function __construct(Request $request, Canal $canal)
    {
        $this->middleware('jwt.verify')->except(['getBySlug']);
        $this->request = $request;
        $this->canal = $canal;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function list()
    {
        $limit = ($this->request->has('limit')) ? $this->request->query('limit') : 10;
        $page = ($this->request->has('page')) ? $this->request->query('page') : 1;
        $select = $this->request->has('select');
        
        $query = $this->canal::query();

        $query->when($select, function ($q, $select) {
            $canaisForSelect = $query::whereRaw('is_active = true AND id <> 9')->get(['id', 'name']);
            return $this->showAll($canaisForSelect, 'Select', 200);
        });


        $canais = $query::where('is_active', true)
            ->paginate($limit);

        $canais->setPath("/canais?limit={$limit}");

        return $this->showAsPaginator($canais, 'Lista de Canais', 200);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $id = DB::table('canais')->insertGetId(
            [
                'name' => $this->request->name,
                'description' => $this->request->description,
                'slug' => $this->request->slug,
                'is_active' => $this->request->is_active,
            ]
        );
        return response()->json([
            'message' => 'Canal cadastrado com sucesso',
            'id' => $id,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Canal  $canal
     * @return \Illuminate\Http\Response
     */
    public function update($id)
    {
        $canal = Canal::find($id);

        $data = [
            'title' => $this->request->title,
            'description' => $this->request->description,
            'is_featured' => $this->request->is_featured,
            'is_approved' => $this->request->is_approved,
            'options' => $this->request->options,
        ];

        $canal->save($data);

        return response()->json($canal->toJson());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Canal  $canal
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $canal = Canal::find($id);
        $resp = [];
        if (is_null($canal)) {
            $resp = [
                'menssage' => 'Canal não encontrado',
                'is_deleted' => false,
            ];
        } else {
            $resp = [
                'menssage' => "Canal de id: {$id} foi excluido com sucesso!!",
                'is_deleted' => $canal->delete(),
            ];
        }

        return response()->json($resp);
    }
    public function getBySlug($slug)
    {
        $canal = Canal::where('slug', 'ilike', $slug)->first();

        return response()->json([
            'success' => true,
            'canal' => $canal,
            'sidebar' => $this->getSideBar($canal->id),
        ]);
    }
    private function getSideBar($id)
    {
        switch ($id) {
            case 1:
            case 2:
            case 3:
            case 12:
                return $this->getSideBarCategories($id);
                break;
            case 7:
                return [];
                break;
            case 5:
                return $this->getSidebarSitesTematicos();
                break;
            case 6:
                return $this->getSideBarAdvancedFilter();
                break;
            case 9:
                return ['categories' => AplicativoCategory::get()];
                break;
        }
    }
    private function getSideBarAdvancedFilter()
    {
        $componentes = CurricularComponentCategory::with('components')->get()->first();
        $tipos = Tipo::select(['id', 'name'])->get();
        $licencas = License::select(['id', 'name'])->whereRaw('parent_id is null')->get();
        $niveis = NivelEnsino::with('components')->get()->first();

        return [
            'components' => $componentes,
            'tipos' => $tipos,
            'licenses' => $licencas,
            'niveis' => $niveis[0]
        ];
    }
    
    private function getSideBarCategories($id)
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
    private function getSidebarSitesTematicos()
    {
        $temas = CurricularComponentCategory::where('id', '=', 3)->with('components')->get()->first();
        $disciplinas = NivelEnsino::where('id', '=', 5)->with('components')->get()->first();

        return [
            "temas" => $temas,
            "disciplinas" => $disciplinas
        ];
    }
    public function search(Request $request, $termo)
    {
        $limit = ($this->request->has('limit')) ? $this->request->query('limit') : 10;
        $page = ($this->request->has('page')) ? $this->request->query('page') : 1;
        $search = "%{$termo}%";
        $canais = Canal::whereRaw("unaccent(lower(name)) LIKE unaccent(lower(?))")
            ->setBindings([$search])
            ->paginate($limit);

        $canais->setPath("/canais/search/{$termo}?limit={$limit}");

        return response()->json([
            'success' => true,
            'paginator' => $canais,
        ]);
    }
}
