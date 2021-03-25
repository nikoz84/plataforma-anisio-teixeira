<?php
namespace App\Http\Controllers;

use App\Models\Aplicativo;
use App\Models\Conteudo;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\ApiController;
use App\Models\ConteudoLike;
use Exception;

class ConteudoLikeController extends ApiController
{
    private $conteudoLike;
    private $request;

    public function __construct(Request $request, ConteudoLike $conteudoLike)
    {
        $this->middleware('auth:api')->except([
            'getLikesPorIdUsuarioEtipo',
            'getLikesByConteudoAplicativo'
        ]);
        $this->conteudoLike = $conteudoLike;
        $this->request = $request;
    }
    /**
     * Lista as curtidas de forma positiva do aplicativo
     */

    public function like()
    {
        $this->request['user_id'] =  Auth::user()->id;
        try {
            $this->existeAPlicativoOuConteudo();
            $this->request->user_id =  Auth::user()->id;
            $this->conteudoLike->like($this->request);
            return $this->successResponse([], 'Ação realizada com sucesso!', 200);
        } catch (Exception $e) {
            return $this->errorResponse([], $e->getMessage(), $e->getCode()>100 && $e->getCode() < 510 ? $e->getCode() : 500);
        }
    }

    public function existeAPlicativoOuConteudo()
    {
        if($this->request->aplicativo_id)
        {
            $aplicativo = Aplicativo::findOrFail($this->request->aplicativo_id);
            if(!$aplicativo)
            throw new Exception("Aplicativo não encontrado");
        }
        else if($this->request->conteudo_id)
        {
            $conteudo = Conteudo::findOrFail($this->request->conteudo_id);
            if(!$conteudo)
            throw new Exception("Conteúdo não encontrado");
        }
        else
        throw new Exception("Conteúdo ou Aplicativo não encontrado");
    }
    /**
     * Lista as curtidas de forma negativa do aplicativo.
     */

    public function dislike()
    {
        
        $this->request['user_id'] =  Auth::user()->id;
        try {
            $this->request->user_id =  Auth::user()->id;
            $this->conteudoLike->dislike($this->request);
            return $this->successResponse([], 'Ação realizada com sucesso!', 200);
        } catch (\Exception $e) {
            return $this->errorResponse([], 'Não foi possível realizar a operação! '.$e->getMessage(), 422);
        }
    }

    /**
     * Lista as curtidas por usuário.
     */

    public function getLikesPorIdUsuarioEtipo()
    {
        $limit = $this->request->query('limit');
        return $this->successResponse($this->conteudoLike->getLikesPorIdUsuarioEtipo(Auth::user()->id, $this->request->tipo, $limit));
    }

    public function getUsuarioLikesConteudoAplicativo($conteudoid, $tipo)
    {
        if ($tipo == "conteudo") {
            $likes = ConteudoLike::where("conteudo_id", $conteudoid)->where("tipo", $tipo)->where("user_id", Auth::user()->id)
                ->get()->first();
        }
        else if($tipo == "aplicativo")
        {
            $likes = ConteudoLike::where("aplicativo_id", $conteudoid)->where("tipo", $tipo)->where("user_id", Auth::user()->id)
                ->get()->first();
        }
        if($likes)
        return $this->showOne($likes);
        return "{}";
    }

    public function getLikesByConteudoAplicativo($condudoAplicativoId , $tipo)
    {
        try{
            if ($tipo == "conteudo") {
                $likes = ConteudoLike::select(DB::raw('count(case when "like" = true then 1 end) AS likes'), DB::raw('count(case when "like" = false then 1 end) AS dislikes'))
                    ->where("conteudo_id", $condudoAplicativoId)->where("tipo", $tipo)->get()->first();
            }
            else if($tipo == "aplicativo")
            {
                $likes = ConteudoLike::select(DB::raw('count(case when "like" = true then 1 end) AS likes'), DB::raw('count(case when "like" = false then 1 end) AS dislikes'))
                ->where("aplicativo_id", $condudoAplicativoId)->where("tipo", $tipo)->get()->first();
            }
        }
        catch(Exception $ex)
        {
            return $this->errorResponse([], $ex->getMessage(), 501);
        }
        
        return $this->showOne($likes);
    }

}
