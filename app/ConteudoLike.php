<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\UserCan;
use Illuminate\Support\Facades\Auth;

class ConteudoLike extends Model
{
   use SoftDeletes, UserCan;

    protected $table = 'conteudos_likes';

    protected $fillable = [
        'user_id',
        'conteudo_id',
        'aplicativo_id',
        'tipo',
        'like'
    ];

    public function like($request)
    {
    	$idPostagem = false;
    	if ($request->tipo == 'conteudo') {
    		$idPostagem = $request->conteudo_id;

    	} else if ($request->tipo == 'aplicativo') {
    		$idPostagem = $request->aplicativo_id;
    	}
        
        $seExisteLike = $this->seExisteLikeOuDeslikeDoUsuarioParaAPostagem(
        	$request->user_id, $idPostagem, $request->tipo
        );

    	if ($seExisteLike) {
    		if ($this->seUsuarioDeuLikeNaPostagem($request->user_id, $idPostagem, $request->tipo)) {
    			$registro = $this->getRegistroPorIdUsuarioEIdPostagem($request->user_id, $idPostagem, $request->tipo);
    			
    			if ($registro->like == true) {
    				$registro->like = false;
    			} else {
    				$registro->like = true;
    			}

    			dd($registro->update());
    		} 

    		// criar um registro
    	}


    	if ($this->seUsuarioDeuLikeNaPostagem($request->user_id, $idPostagem, $request->tipo)) {
    		$request->request->add(['like' => false]);
    		return $this->create($request->all());
    	} else {
    		$request->request->add(['like' => true]);
    		return $this->create($request->all());
    	}
    	
    	return $this->create($request->all());
    }

    public function deslike()
    {

    }

    public function seUsuarioDeuLikeNaPostagem($idUsuario, $idPostagem, $tipo)
    {
    	$like = false;
    	if ($tipo == 'conteudo') {
            $like = $this->where('conteudo_id', $idPostagem)->where('user_id', $idUsuario);

        } else if ($tipo == 'aplicativo') {
            $like = $this->where('aplicativo_id', $idPostagem)->where('user_id', $idUsuario);
        } 

        if ($like) {
        	return true;
        }

        return false;
    }

    public function seExisteLikeOuDeslikeDoUsuarioParaAPostagem($idUsuario, $idPostagem, $tipo)
    {
    	return $this->where('user_id', $idUsuario)
    	    ->orWhere('conteudo_id', $idPostagem)
    	    ->orWhere('aplicativo_id', $idPostagem)->count();
    }

    public function getRegistroPorIdUsuarioEIdPostagem($idUsuario, $idPostagem, $tipo)
    {
    	$like = false;
    	if ($tipo == 'conteudo') {
    		$like = $this->where('conteudo_id', $idPostagem)->where('user_id', $idUsuario);

    	} else if ($tipo == 'aplicativo') {
            $like = $this->where('aplicativo_id', $idPostagem)->where('user_id', $idUsuario);
        } 

        return $like->first();
    }
}