<?php

namespace App\Http\Controllers;
use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use App\ConteudoLike;

class ConteudoLikeController extends ApiController
{
    private $conteudoLike;
    private $request;

    public function __construct(Request $request, ConteudoLike $conteudoLike)
    {
        $this->conteudoLike = $conteudoLike;
        $this->request = $request;

        $this->middleware('auth:api')->except([
            'like',
            'deslike',
            'getLikesPorIdUsuarioEtipo'
        ]);
        $request = $request;
    }
    /**
     * Lista as curtidas de forma positiva do aplicativo
     */

    public function like()
    {
        try {
            $this->conteudoLike->like($this->request);
            return $this->successResponse([], 'Ação realizada com sucesso!', 200);
        } catch (\Exception $e) {
            return $this->errorResponse([], 'Não foi possível realizar a operação!', 422);
        }
    }

    /**
     * Lista as curtidas de forma negativa do aplicativo.
     */

    public function deslike()
    {
        try {
            $this->conteudoLike->deslike($this->request);
            return $this->successResponse([], 'Ação realizada com sucesso!', 200);
        } catch (\Exception $e) {
            return $this->errorResponse([], 'Não foi possível realizar a operação!', 422);
        }
    }

    /**
     * Lista as curtidas por usuário.
     */

    public function getLikesPorIdUsuarioEtipo($idUsuario, $tipo = false)
    {
        $limit = $this->request->query('limit');
        return $this->successResponse($this->conteudoLike->getLikesPorIdUsuarioEtipo($idUsuario, $tipo, $limit));
    }
}
