<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use App\Comentario;

class ComentarioController extends ApiController
{
    private $comentario;
    private $request;

	public function __construct(Request $request, Comentario $comentario)
    {
        $this->comentario = $comentario; 
        $this->request = $request;

        $this->middleware('auth:api')->except([
            'create', 
            'comentarios', 
            'getComentariosByIdUsuario', 
            'deletar'
        ]);
        $request = $request;
    }

    public function create(Request $request)
    {
    	try {
    		$this->comentario->create($request->all());
    		return $this->successResponse([], 'Comentário criado com sucesso!', 200);

    	} catch(\Exception $e) {
    		return $this->errorResponse([], 'Não foi possível criar o comentário!', 422);
    	}
    }

    public function update(Request $request)
    {
        $comentario = $this->comentario->find($request->id);
        return $this->successResponse($comentario);
    }
    
    # Retorna os comentarios sobre uma determinada postagem
    public function getComentariosByIdPostagem($idPostagem)
    {
        $comentario = $this->comentario->find($id);

        if ( ! is_null($comentario)) {
            return $this->successResponse($comentario);
        }

        return $this->errorResponse([], 'Comentário não encontrado!', 422);
    }
    
    # Retorna os comentarios por id do usuario e pelo tipo
    public function getComentariosByIdUsuario($idUsuario, $tipo = false)
    {
        $comentarios = $this->comentario->getComentariosByIdUsuario($idUsuario, $tipo);

        if (count($comentarios) > 0) {
            return $this->successResponse($comentarios);
        }

        return $this->errorResponse([], 'Comentários não encontrados!', 422);
    }

    public function deletar($id)
    {
        if ($this->comentario->deletar($id)) {
            return $this->successResponse([], 'Comentario deletado com Sucesso!', 200);
        }

        return $this->errorResponse([], 'Erro ao deletar comentario!', 422);
    }
}
