<?php

namespace App\Http\Controllers;

use App\Canal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\ApiController;

class CanalController extends ApiController
{
    public function __construct(Request $request)
    {
        $this->middleware('jwt.verify')->except(['list', 'search', 'getBySlug']);
        $this->request = $request;
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

        if ($this->request->has('select')) {
            $canaisForSelect = Canal::whereRaw('is_active = true AND id <> 9')->get(['id', 'name']);
            return $this->showAll($canaisForSelect, 'Select', 200);
        }


        $canais = Canal::where('is_active', true)
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
                'name' => $this->request->get('name'),
                'description' => $this->request->get('description'),
                'slug' => 'teste-slug',
                'is_active' => true,
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
            'title' => $this->request->get('title'),
            'description' => $this->request->get('description'),
            'is_featured' => $this->request->get('is_featured'),
            'is_approved' => $this->request->get('is_approved'),
            'options' => $this->request->get('options'),
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
                return [

                ];
                break;
            case 5:
                return $this->getSidebarSitesTematicos();
                break;
            case 6:
                return $this->getSideBarAdvancedFilter();
                break;
            case 9:
                return ['categories' => \App\AplicativoCategory::get()];
                break;
        }
    }
    private function getSideBarAdvancedFilter()
    {
        $componentes = \App\CurricularComponentCategory::with('components')->get()->first();
        $tipos = \App\Tipo::select(['id', 'name'])->get();
        $licencas = \App\License::select(['id', 'name'])->whereRaw('parent_id is null')->get();
        $niveis = \App\NivelEnsino::with('components')->get()->first();
        
        return [
            'components' => $componentes,
            'tipos' => $tipos,
            'licenses' => $licencas,
            'niveis' => $niveis[0]
        ];
    }
    private function getSideBarCategories($id)
    {
        $categories = \App\Category::selectRaw("id, parent_id, name, options->'is_active' as is_active")
                    ->where('canal_id', $id)
                    ->whereRaw('parent_id is null')
                    ->where('options->is_active', 'true')
                    ->with('subCategories')
                    ->orderBy('created_at', 'asc')
                    ->get();
        $disciplinas= [];
        if ($id == 2) {
            $disciplinas = \App\NivelEnsino::where('id', '=', 5)->with('components')->get()->first();
            return [
                'categories' => $categories,
                'disciplinas' => $disciplinas
            ];
        }

        return ['categories' => $categories];
    }
    private function getSidebarSitesTematicos()
    {
        $temas = \App\CurricularComponentCategory::where('id', '=', 3)->with('components')->get()->first();
        $disciplinas = \App\NivelEnsino::where('id', '=', 5)->with('components')->get()->first();

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
