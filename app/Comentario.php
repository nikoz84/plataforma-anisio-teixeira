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

    public function getComentariosByIdUsuario($userId, $tipo = false)
    {
    	$comentarios = $this->where('user_id', $userId);
    	if ($tipo) {
    		$comentarios->where('tipo', $tipo);
    	}

    	return $comentarios->get();
    }

    public function getComentarioById($id)
    {
    	//return $this->

    }

    public function getComentariosByTipo($tipo)
    {
    	return $this->where('tipo', $tipo)->get();
    }

    public function delete($id)
    {
    	return $this->where('id', $id)->delete();
    }
}