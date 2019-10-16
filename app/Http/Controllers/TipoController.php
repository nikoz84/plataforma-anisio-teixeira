<?php

namespace App\Http\Controllers;

use App\Http\Controllers\ApiController;
use App\Tipo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Traits\ApiResponser;

class TipoController extends ApiController
{
    use ApiResponser;

    public function __construct(Tipo $tipo, Request $request)
    {
        $this->middleware('jwt.verify')->except(['index']);
        $this->tipo = $tipo;
        $this->request = $request;
    }

    public function index()
    {
        $limit = $this->request->query('limit', 15);
        if ($this->request->has('select')) {
            $tipos = $this->tipo::all();
            return $this->fetchForSelect(collect($tipos));
        }
        $query = $this->tipo;

        $paginator = $query->paginate($limit)
            ->setPath("/tipos?limit={$limit}");

        return $this->showAsPaginator($paginator, '', 200);
    }

    public function create()
    {
        $validator = Validator::make($this->request->all(), config("rules.tipos"));
        if ($validator->fails()) {
            return $this->errorResponse($validator->errors(), "Não foi possível criar o tipo", 201);
        }
        $tipo = $this->tipo;
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
            return $this->errorResponse($validator->errors(), "Não foi possível atualizar o tipo", 201);
        }

        $tipo = $this->tipo;
        $tipo->name = $this->request->name;
        $tipo->options = json_decode($this->request->options, true);
        $tipo->options = $this->request->options;

        $cat = $this->tipo::find($id);
        $cat->fill($this->request->all());

        if ($cat->update()) {
            return $this->successResponse($cat, 'Categoria editada com sucesso!', 200);
        } else {
            return $this->errorResponse($tipo, 'Não existe essa categoria para ser atualizada', 200);
        }
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
