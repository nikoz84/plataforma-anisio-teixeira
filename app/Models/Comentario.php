<?php

namespace App\Models;

use App\Traits\UserCan;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comentario extends Model
{
    use SoftDeletes;use UserCan;

    /**Tabela com campo definido */
    protected $table = 'comentarios';

    /**Tabela com campos definidos */
    protected $fillable = [
        'user_id',
        'conteudo_id',
        'aplicativo_id',
        'body',
        'tipo',
    ];

    /**
     * Retorna Comentário do Id do Usuário
     *
     * @param  mixed  $userId identificador único
     * @param  mixed  $tipo boolean
     * @return bool
     */
    public function getComentariosByIdUsuario($userId, $tipo = false)
    {
        $comentarios = $this->where('user_id', $userId);
        if ($tipo) {
            $comentarios->where('tipo', $tipo);
        }

        if ($comentarios->exists()) {
            return $comentarios;
        }

        return false;
    }

    /**
     * Retorna Postagem com Id da Postagem
     *
     * @param  int  $idPostagem
     * @param  string  $tipo
     * @param  mixed  $query
     * @return void
     */
    public function scopeComentariosById($query, $idPostagem, $tipo)
    {
        if (! $idPostagem || ! $tipo) {
            return $query;
        }

        return $query->when($tipo == 'conteudo', function ($q) use ($idPostagem) {
            return $q->where('conteudo_id', $idPostagem);
        })->when($tipo == 'aplicativo', function ($q) use ($idPostagem) {
            return $q->where('aplicativo_id', $idPostagem);
        });

        /*
        $comentarios = null;
        if ($tipo == 'conteudo') {
            $comentarios = $this->where('conteudo_id', $idPostagem);
        } elseif ($tipo == 'aplicativo') {
            $comentarios = $this->where('aplicativo_id', $idPostagem);
        }

        return $comentarios;
        */
    }

    /**
     * Retorna Comentário Por id
     *
     * @param  int  $id
     * @return booleano
     */
    public function getComentarioById($id)
    {
        $comentario = $this->find($id);
        if (! is_null($comentario)) {
            return $comentario;
        }

        return false;
    }

    /**
     * Retorna Comentário Por Tipo.
     *
     * @param  int  $tipo
     * @return void
     */
    public function getComentariosByTipo($tipo)
    {
        return $this->where('tipo', $tipo)->get();
    }

    /**
     * Deleta Informações
     *
     * @param [int] $id
     * @return int
     */
    public function deletar($id)
    {
        return $this->where('id', $id)->delete();
    }
}
