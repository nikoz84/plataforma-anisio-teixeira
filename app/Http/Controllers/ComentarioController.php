<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\Validator;
use App\Models\Comentario;

class ComentarioController extends ApiController
{
    protected $comentario;
    protected $request;

    public function __construct(Request $request, Comentario $comentario)
    {
        $this->comentario = $comentario;
        $this->request = $request;

        $this->middleware('auth:api')->except([
            'create',
            'update',
            'comentarios',
            'getComentariosByIdUsuario',
            'getComentariosByIdPostagem',
            'getComentarioById',
            'deletar'
        ]);
    }
    /**
     * Metodo que cria retorna uma listagem do banco de dados e valida
     * @param \App\Comentario $comentario
     * @return \App\Controllers\ComentarioController\ApiResponser
     * retorna json
     */
    public function create()
    {
        $validator = Validator::make(
            $this->request->all(),
            ['recaptcha' => ['required', new \App\Rules\ValidRecaptcha]]
        );

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors(), "Usuário não validado", 422);
        }

        try {
            $this->comentario->create($this->request->all());
            return $this->successResponse([], 'Comentário criado com sucesso!', 200);
        } catch (\Exception $e) {
            return $this->errorResponse([], 'Não foi possível criar o comentário!', 422);
        }
    }
    /**
     * Retorna o comentario pelo seu id, ou seja, chave primaria
     * @param [type] $id
     * @param \App\Comentario $comentario
     * @return \App\Controllers\ApiResponser
     * retorna json
     */

    public function getComentarioById($id)
    {
        $comentario = $this->comentario->getComentarioById($id);
        if ($comentario) {
            return $this->successResponse($comentario);
        }

        return $this->errorResponse([], 'Comentário não encontrado!', 422);
    }
    /**
     * Atualiza o Aplicativo no banco de dados
     * @param int $id identificador único
     * @param \App\Comentario $comentario
     * @return \App\Controller\ApiResponser
     * retorna json
     */

    public function update($id)
    {
        $validator = Validator::make(
            $this->request->all(),
            ['recaptcha' => ['required', new \App\Rules\ValidRecaptcha]]
        );

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors(), "Usuário não validado", 422);
        }

        $comentario = $this->comentario->find($id);
        $body = $this->request->only(['body']);

        try {
            $comentario->update($body);
            return $this->successResponse([], 'Comentário editado com sucesso!', 200);
        } catch (\Exception $e) {
            return $this->errorResponse([], 'Não foi possível editar o comentário!', 422);
        }
    }
    /**
     * Retorna os comentarios sobre uma determinada postagem
     * @param integer $idPostagem identificador único do recurso
     * @param string $tipo tabela conteudo ou aplicativo
     * 
     * @return string json
     */

    public function getComentariosByIdPostagem($idPostagem, $tipo)
    {
        $limit = $this->request->query('limit');
        $query = $this->comentario::query();

        $comentarios =  $query->comentariosById($idPostagem, $tipo)
            ->paginate($limit);

        if ($comentarios) {
            return $this->successResponse($comentarios);
        }

        return $this->errorResponse([], 'Comentários não encontrado!', 422);
    }

    /**
     * Retorna os comentarios por id do usuario e pelo tipo
     * @param [type] $idUsuario
     * @param boolean $tipo
     * @return void
     */
    public function getComentariosByIdUsuario($idUsuario, $tipo = false)
    {
        $limit = $this->request->query('limit');
        $comentarios = $this->comentario->getComentariosByIdUsuario($idUsuario, $tipo);

        if ($comentarios) {
            return $this->successResponse($comentarios->paginate($limit));
        }

        return $this->errorResponse([], 'Comentários não encontrados!', 422);
    }
    /**
     * Deleta aplicativo no banco de dados
     * @param int $id identificador único
     * @param \App\Comentario $comentario
     * @return \App\Controller\ApiResponser
     * retorna json
     */

    public function deletar($id)
    {
        if ($this->comentario->deletar($id)) {
            return $this->successResponse([], 'Comentario deletado com Sucesso!', 200);
        }

        return $this->errorResponse([], 'Erro ao deletar comentario!', 422);
    }
}
