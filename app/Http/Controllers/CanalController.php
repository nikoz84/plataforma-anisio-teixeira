<?php

namespace App\Http\Controllers;

use App\Canal;
use App\Helpers\SideBar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\ApiController;
<<<<<<< HEAD
use App\Traits\ApiResponser;
=======
use Illuminate\Support\Facades\Auth;
use Gate;
>>>>>>> 52abfe2f7043b521e96981d420344837f728b11d

class CanalController extends ApiController
{
    use ApiResponser;

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
        if ($this->request->has('select')) {
            $select = $this->canal::whereRaw('is_active = true AND id <> 9 AND id <> 7 AND id <> 8')
                ->orderBy('id')
                ->get(['id', 'name']);
            return $this->fetchForSelect(collect($select));
        }
        $query = $this->canal::query();

        $canais = $query->where('is_active', true)
            ->paginate($limit);

        $canais->setPath("/canais?limit={$limit}");

        return $this->showAsPaginator($canais, 'Lista de Canais', 200);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return json
     */
    public function create()
    {

        $canal = $this->canail::create(
            [
                'name' => $this->request->name,
                'description' => $this->request->description,
                'slug' => $this->request->slug,
                'is_active' => $this->request->is_active,
            ]
        );
        return response()->json([
            'message' => 'Canal cadastrado com sucesso',
            'id' => $canal
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id)
    {
        $canal = $this->canal::find($id);

        if (Gate::denies('super-admin', $canal)) {
            return $this->errorResponse([], 'Usuário sem permissão de acesso!', 403);
        }

        $data = [
            'title' => $this->request->title,
            'description' => $this->request->description,
            'is_featured' => $this->request->is_featured,
            'is_approved' => $this->request->is_approved,
            'options' => $this->request->options,
        ];

        $canal->save($data);

        return $this->successResponse($canal, 'Canal Editado com sucesso!', 200);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Canal  $canal
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $canal = $this->canal::find($id);
        if (Gate::denies('super-admin', $canal)) {
            return $this->errorResponse([], 'Usuário sem permissão de acesso!', 403);
        }
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

        $canal = $this->canal::where('slug', 'ilike', $slug)->first();

        return response()->json([
            'success' => true,
            'canal' => $canal,
            'sidebar' => Sidebar::getSideBar($canal->id),
        ]);
    }

    public function search($termo)
    {
        $limit = ($this->request->has('limit')) ? $this->request->query('limit') : 10;

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
