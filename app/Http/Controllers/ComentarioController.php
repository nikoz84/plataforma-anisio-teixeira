<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use App\Comentario;

class ComentarioController extends ApiController
{
    protected $comentario;
    protected $request;

    public function __construct(Request $request, Comentario $comentario)
    {
        $this->comentario = $comentario;
        $this->request = $request;

        $this->middleware('auth:api')->except([
            'create', 'teste', 'comentarios'
        ]);
        $request = $request;
    }

    public function create(Request $request)
    {
        $comentario = new Comentario();
        
        try {
            $comentario->create($request->all());
            return $this->successResponse([], 'Comentário criado com sucesso!', 200);
        } catch (\Exception $e) {
            return $this->errorResponse([], 'Não foi possível criar o comentário!', 422);
        }
    }

    public function update(Request $request)
    {
        $comentario = new Comentario();
        $comentario = $comentario->find($request->id);

        return $this->successResponse($comentario);
    }

    public function comentarios($id)
    {
        $comentario = new Comentario();
        $comentario = $comentario->find($id);

        if (!is_null($comentario)) {
            return $this->successResponse($comentario);
        }

        return $this->errorResponse([], 'Comentário não encontrado!', 422);
    }
}
