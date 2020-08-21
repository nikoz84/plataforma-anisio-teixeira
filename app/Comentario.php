<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Traits\FileSystemLogic;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\UserCan;
use Illuminate\Support\Facades\Auth;

class Comentario extends Model
{
    use SoftDeletes, UserCan;

    protected $table = 'comentarios';

    protected $fillable = [
        'user_id',
        'conteudo_id',
        'aplicativo_id',
        'body',
        'tipo'
    ];
     /**
      * Retorna Comentário do Id do Usuário
      * 
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
       * @param [type] $idPostagem
       * @param [type] $tipo
       * @return void
       */
    public function getComentariosByIdPostagem($idPostagem, $tipo)
    {
        $comentarios = false;
        if ($tipo == 'conteudo') {
            $comentarios = $this->where('conteudo_id', $idPostagem);
        } elseif ($tipo == 'aplicativo') {
            $comentarios = $this->where('aplicativo_id', $idPostagem);
        }

        if ($comentarios) {
            return $comentarios;
        }

        return false;
    }
      /**
       * Retorna Comentário Por id
       *
       * @param [int] $id
       * @return void
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
       * @param [int] $tipo
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
        * @return void
        */
    public function deletar($id)
    {
        return $this->where('id', $id)->delete();
    }
}
