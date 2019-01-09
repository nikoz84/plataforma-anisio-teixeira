<?php

namespace App\Http\Controllers;

use App\Canal;
use App\Conteudo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CanalController extends Controller
{
    public function __construct(Request $request)
    {
        $this->middleware('jwt.verify')->except(['list','search','getBySlug']);
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
        
        if ($this->request->has('name')) {
            $name = $this->request->query('name');
            $canais = Canal::where('name', $name)
                        ->paginate($limit);
            $canais->setPath("/canais?name={$name}limit={$limit}");
            return response()->json([
                'success' => true,
                'paginator' => $canais
            ]);
        }
        $canais = Canal::where('is_active', true)
                        ->paginate($limit);
        
        $canais->setPath("/canais?limit={$limit}");

        return response()->json([
            'success'=> true,
            'title'=> 'Lista de canais',
            'paginator' => $canais,
            'page'=> $canais->currentPage(),
            'limit' => $canais->perPage()
        ]);
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
                'is_active' => true
            ]
        );
        return response()->json([
            'message' => 'Canal cadastrado com sucesso',
            'id' => $id
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
            'options' => $this->request->get('options')
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
                'is_deleted' => false
            ];
        } else {
            $resp = [
                'menssage' => "Canal de id: {$id} foi excluido com sucesso!!",
                'is_deleted' => $canal->delete()
            ];
        }

        return response()->json($resp);
    }
    public function getBySlug($slug)
    {
        $canal = Canal::where('slug', 'ilike', $slug)->first();

        return response()->json([
            'success'=> true,
            'canal' => $canal,
            'sidebar' => $this->getSideBar($canal->id)
        ]);
    }
    private function getSideBar($id)
    {
        switch ($id) {
            case 1:
            case 2:
            case 3:
            case 12:
                $categories =  \App\Category::selectRaw("id, parent_id, name, options->'is_active' as is_active")->where('canal_id', $id)
                ->whereRaw('parent_id is null')
                ->where('options->is_active', 'true')
                ->with('subCategories')
                ->orderBy('name', 'asc')
                ->get();
                return $categories;
            break;
            case 5:
                return [
                    'temas' => \App\CurricularComponentCategory::where('id', '=', 3)->with('components')->get(),
                    'disciplinas' => \App\NivelEnsino::where('id', '=', 5)->with('components')->get()
                ];
            break;
            case 9:
                return \App\AplicativoCategory::select(['id', 'name'])->get();
            break;
        }
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
            'success'=> true,
            'paginator' => $canais
        ]);
    }
}
