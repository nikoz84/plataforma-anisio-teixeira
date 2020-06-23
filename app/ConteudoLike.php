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
    	# Verifica se o like ou deslike é para um (conteudo ou aplicativo) e retorna o id
    	$idPostagem = $this->retornaOIdDaPostagemCorretaBaseandoseNoTipo($request);
    	
        $seExisteLike = $this->seExisteLikeOuDeslikeDoUsuarioParaAPostagem(
        	$request->user_id, $idPostagem, $request->tipo
        );
        
        # Se o usuario já deu algum like ou deslike na postagem
    	if ($seExisteLike) {
    		# Recupera o registro 
			$registro = $this->getRegistroPorIdUsuarioEIdPostagem($request->user_id, $idPostagem, $request->tipo);
			
			# Verifica se foi um like ou deslike
			if ($registro->like == true) {
				$registro->like = null;
			} else {
				$registro->like = true;
			}
            
            # Edita o campo like com true ou false levando em concideração a validação acima
			return $registro->update();
    	}
        
        # Se o usuario nunca deu like ou deslike na postagem, 
    	$request->request->add(['like' => true]);
    	return $this->create($request->all());
    }

    public function deslike($request)
    {
    	# Verifica se o like ou deslike é para um (conteudo ou aplicativo) e rtorna o id
    	$idPostagem = $this->retornaOIdDaPostagemCorretaBaseandoseNoTipo($request);

    	$seExisteLike = $this->seExisteLikeOuDeslikeDoUsuarioParaAPostagem(
        	$request->user_id, $idPostagem, $request->tipo
        );

        # Se o usuario já deu algum like ou deslike na postagem
    	if ($seExisteLike) {
    		# Recupera o registro 
			$registro = $this->getRegistroPorIdUsuarioEIdPostagem($request->user_id, $idPostagem, $request->tipo);
			
			# Se foi um like anteriormente, então dá deslike, ou seja, false
			if ($registro->like == true) {
				$registro->like = false;
            
            # Se estiver em status null, aplica false, ou seja, deslike
			} else if (is_null($registro->like)) {
				$registro->like = false;
            
            # Se estiver am false, ou seja, deslike aplica null
			} else {
				$registro->like = null;
			}
            
            # Edita o campo like com true ou false levando em concideração a validação acima
			return $registro->update();
    	}

    	# Se o usuario nunca deu like ou deslike na postagem, 
    	$request->request->add(['like' => false]);
    	return $this->create($request->all());
    }

    /**
    * Recebe o request e verifica de o like ou deslike é para um (conteudo ou aplicativo)
    * @param objeto request
    * @return id da postagem que pode ser conteudo ou aplicativo
    */
    protected function retornaOIdDaPostagemCorretaBaseandoseNoTipo($request)
    {
    	if ($request->tipo == 'conteudo') {
    		return $idPostagem = $request->conteudo_id;

    	} else if ($request->tipo == 'aplicativo') {
    		return $idPostagem = $request->aplicativo_id;
    	}
    }
    
    /**
    * Verifica se o usuario já deu like ou deslike na postagem
    * @param idUsuario, id do usuario
    * @param idPostagem, pode ser conteudo_id ou aplicativo_id
    * @param tipo, se é conteudo ou aplicativo
    * @return bool
    */
    protected function seExisteLikeOuDeslikeDoUsuarioParaAPostagem($idUsuario, $idPostagem, $tipo)
    {
    	$like = $this->where('user_id', $idUsuario);
    	if ($tipo == 'conteudo') {
    		return $like->where('conteudo_id', $idPostagem)->count();

    	} else if ($tipo == 'aplicativo') {
    		$like->where('aplicativo_id', $idPostagem)->count();
    	} 
    }
    
    /**
    * Recupera um registro de like ou seslike do usuario vinculado a uma postagem
    * @param idUsuario, id do usuario
    * @param idPostagem, pode ser conteudo_id ou aplicativo_id
    * @param tipo, se é conteudo ou aplicativo
    * @return Object
    */
    protected function getRegistroPorIdUsuarioEIdPostagem($idUsuario, $idPostagem, $tipo)
    {
    	if ($tipo == 'conteudo') {
    		return $this->where('conteudo_id', $idPostagem)->where('user_id', $idUsuario)->first();

    	} else if ($tipo == 'aplicativo') {
            return $this->where('aplicativo_id', $idPostagem)->where('user_id', $idUsuario)->first();
        } 
    }
    
    /**
    * Retorna registros de likes e deslikes do usuario
    * @param idUsuario, id do usuario
    * @param tipo, se é conteudo ou aplicativo
    * @param queryString limit
    * @return Object
    */
    public function getLikesPorIdUsuarioEtipo($idUsuario, $tipo = false, $limit = false)
    {
    	$likes = $this->where('user_id', $idUsuario);
    	if ($tipo) {
    		$likes->where('tipo', $tipo);
    	}

    	return $likes->paginate($limit);
    }
}