<?php

namespace App\Http\Controllers;

use App\Http\Controllers\ApiController;
use App\Tipo;
use Illuminate\Support\Facades\Validator;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;

class TipoController extends ApiController
{
    use ApiResponser;

    public function __construct(Request $request)
    {
        $this->middleware('jwt.verify')->except(['index']);
        $this->request = $request;
    }

    public function index()
    {
        $limit = $this->request->query('limit', 15);
        if ($this->request->has('select')) {
            $tipos = Tipo::all();
            return $this->fetchForSelect(collect($tipos));
        }
        $query = Tipo::query();

        $paginator = $query->select()->paginate($limit);
        $paginator->setPath("/tipos?limit={$limit}");

        return $this->showAsPaginator($paginator);
    }

    public function create()
    {
        $validator = Validator::make($this->request->all(), config("rules.tipos"));
        if ($validator->fails()) {
            return $this->errorResponse($validator->errors(), "Não foi possível criar o tipo", 201);
        }
        $tipo = new Tipo;
        $tipo->name = $this->request->name;
        $tipo->options = json_decode($this->request->options, true);

        if ($tipo->save()) {
            return $this->successResponse($tipo, 'Tipo criado com sucesso!', 200);
        }
    }

    public function update($id)
    {
        $validator = Validator::make($this->request->all(), config("rules.tipos"));

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors(), "Preencha o formulário corretamente", 422);
        }

        $tipo = Tipo::findOrFail($id);

        $this->authorize('update', $tipo);

        $tipo->name = $this->request->name;

        $tipo->options = json_decode($this->request->options, true);
        $tipo->options = $this->request->options;

        if (!$tipo->save()) {
            return $this->errorResponse([], 'Não foi possível editar', 422);
        }

        $this->successResponse($tipo, 'Tipo de conteúdo editado com sucesso!', 200);
    }
    public function delete($id)
    {
        $validator = Validator::make($this->request->all(), [
            'delete_confirmation' => ['required', new \App\Rules\ValidBoolean],
        ]);
        if ($validator->fails()) {
            return $this->errorResponse($validator->errors(), "Não foi possível deletar.", 201);
        }
        $tipo = $this->tipo;
        $resp = $this->tipo::findOrFail($id);

        if ($resp->delete()) {
            return $this->successResponse($tipo, 'Tipo deletado com sucesso!', 200);
        }
    }
    public function getTiposById($id)
    {
        $tipo = $this->tipo::find($id);
        return $this->showOne($tipo);
    }
}
